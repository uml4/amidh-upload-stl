<?php
namespace Bookly\Lib;

use Bookly\Lib;

/**
 * Class Scheduler
 * @package BooklyRecurringAppointments\Lib
 */
class EaIntegration
{
    const REPEAT_DAILY    = 'daily';
    const REPEAT_WEEKLY   = 'weekly';
    const REPEAT_BIWEEKLY = 'biweekly';
    const REPEAT_MONTHLY  = 'monthly';
    const REPEAT_YEARLY   = 'yearly';//not implemented yet

    private $ea_api_url;

    private $ea_user_name;

    private $ea_user_pass;

   private $request_header;


    /**
     * Constructor.    
     */
    public function __construct(  )
    {
        // Set up UserBookingData.
        $this->ea_api_url = esc_attr( get_option( 'ab_settings_ea_api_url' , '' ) );
        $this->ea_user_name = esc_attr( get_option( 'ab_settings_ea_admin_user_name' , '' ) );
        $this->ea_user_pass = esc_attr( get_option( 'ab_settings_ea_admin_password' , '' ) );
            
        $this->request_header = array(
                                 'Authorization' => 'Basic ' . base64_encode( $this->ea_user_name . ':' . $this->ea_user_pass )
                                    );
        
    }

    
    
    public function getProviders($id = null ) {
        
        $url = $this->ea_api_url; 
        if($id) {
            $url = $url.'providers/'.$id;
        } else {
            $url = $url.'providers/';
        }
        
        return (array) $this->proceedRequest($url);
        
    }
    
    public function getServices($id = null ) {
        
        $url = $this->ea_api_url; 
        if($id) {
            $url = $url.'services/'.$id;
        } else {
            $url = $url.'services/';
        }
        
       return (array) $this->proceedRequest($url);
        
    }

    
    /**
     * 
     * @param type $url
     * @param type $req_type
     * @param type $req_params
     * @return \Bookly\Lib\HttpRespone
     */
    private function proceedRequest($url, $req_type = 'GET', $req_params = array() ) {
        
        $request = new \WP_Http();
        $agr['headers'] = $this->request_header;
        
        
        
        if(strtoupper($req_type) == 'POST') {
            if(count($req_params)) {
                $agr['body'] = json_encode($req_params);
            }
            
            $response = $request->post( $url, $agr );
            
        } else {
            $response = $request->get( $url, $agr );
        }
        
        $httpResponse = new HttpRespone();
        $response_code = $response['response']['code'];
        $httpResponse->code = $response_code;
        //var_dump($response);
        if($response_code == HttpRespone::CODE_404 || $response_code == HttpRespone::CODE_500
                || $response_code == HttpRespone::CODE_401 
                ) {
            $httpResponse->error_message = $response['body'];
            
        } else {
            $httpResponse->body = json_decode($response['body'],true);
        }
        
        return $httpResponse;
    } 
    
    
}