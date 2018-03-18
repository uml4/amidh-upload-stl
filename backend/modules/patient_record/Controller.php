<?php
namespace Bookly\Backend\Modules\PatientRecord;

use Bookly\Lib;

/**
 * Class Controller
 * @package Bookly\Backend\Modules\Customers
 */
class Controller extends Lib\Base\Controller
{
    const page_slug = 'bookly-patient-record';

      protected function getPermissions()
    {
        return array(
            'executeSaveCustomer' => 'user',
        );
    }

    public function index()
    {
        
        wp_enqueue_media();
        $this->enqueueStyles( array(
            'backend'  => array( 'bootstrap/css/bootstrap-theme.min.css','css/jquery-ui-theme/jquery-ui.min.css' ),
            'frontend' => array( 'css/ladda.min.css', ),
        ) );

        $this->enqueueScripts( array(
            'backend' => array(
                'bootstrap/js/bootstrap.min.js' => array( 'jquery' , 'jquery-ui-datepicker' ),
                'js/datatables.min.js' => array( 'jquery' ),
            ),
            'frontend' => array(
                'js/spin.min.js' => array( 'jquery' ),
                'js/ladda.min.js' => array( 'jquery' ),
            ),
            'module' => array(
                'js/record.js' => array( 'bookly-datatables.min.js'),
                'js/jquery.ui.widget.js' ,
                'js/jquery.iframe-transport.js' ,
                'js/jquery.fileupload.js' ,
            ),
        ) );
        $url =  esc_url( add_query_arg( array('page'=> $this->page_slug, 'page'=> 'bookly-patient-record')) );
        wp_localize_script( 'bookly-record.js', 'BooklyL10n', array(
             'ajaxurl'            => admin_url('admin-ajax.php'),
            'csrf_token'      => Lib\Utils\Common::getCsrfToken(),
            'first_last_name' => (int) Lib\Config::showFirstLastName(),
            'edit'            => __( 'Edit', 'bookly' ),
            'are_you_sure'    => __( 'Are you sure?', 'bookly' ),
            'wp_users'        => get_users( array( 'fields' => array( 'ID', 'display_name' ), 'orderby' => 'display_name' ) ),
            'zeroRecords'     => __( 'No customers found.', 'bookly' ),
            'processing'      => __( 'Processing...', 'bookly' ),
            'edit_customer'   => __( 'Edit customer', 'bookly' ),
            'new_customer'    => __( 'New customer', 'bookly' ),
            'create_customer' => __( 'Create customer', 'bookly' ),
            'save'            => __( 'Save', 'bookly' ),
            'search'          => __( 'Quick search customer', 'bookly' ),
            'url' => $url
        ) );

         if( $_GET['todetail'] == "1"){
             $this->detailTabPage();
         } else {
             
             $this->recordTabPage();
         }
        
        
    }
  
    
    private function recordTabPage() {
        
        
        
        
        
        $this->render( 'index' );
    }

    private function detailTabPage() {
        
         $this->enqueueScripts( array(   
                
                'module' => array( 
                    'js/Detector.js' ,
                    'js/three.min.js' ,
                    'js/wpWebGL.js' ,
                )
            ));
        
        
        $url =  esc_url( add_query_arg( array('page'=> $this->page_slug, 'page'=> 'bookly-patient-record','todetail'=>1 )) );
        //get all StaffCustomerDetail
        $staffCustomerDetails = Lib\Entities\StaffCustomerDetail::query( 'scd' )
                                                            ->select('*')
                                                            ->where('medical_id', $_GET['sc'] )->fetchArray();
        
        
        $p = isset( $_GET['p'])?$_GET['p']:0;
        $curentStaffCustomerDetail = $staffCustomerDetails[$p];
        
        
        
        $this->render( 'detail', array('url'=> $url, 'staffCustomerDetails' => $staffCustomerDetails, 'curentStaffCustomerDetail' => $curentStaffCustomerDetail ) );
    }



    /**
     * Get list of customers.
     */
    public function executeSaveCheckAppointment()
    {
        global $wpdb;
        $response = array();
        $data = $this->getParameter( 'data' );
        
        $wp_staff_id = get_current_user_id();
        
        $staffCustomer = new Lib\Entities\StaffCustomer();
        $staffCustomer->loadBy(array('staff_wp_id' => $wp_staff_id,'customer_id' => $data['customer_id'] ));
        $response['success']  = true;
        if(!$staffCustomer->isLoaded()) {
            $staffCustomer->staff_wp_id = $wp_staff_id;
            $staffCustomer->customer_id = $data['customer_id'];
            $staffCustomer->created_date = $data['appointment_date'];
            $staffCustomer->comment = $data['medical_comment'];
            $staffCustomer->save();
            
        } else {
                if(    date('Y-m-d',  strtotime($staffCustomer->created_date))  ==  $data['appointment_date'] ) {
                        $response['success']  = FALSE;
                } else {
                    $staffCustomer = new Lib\Entities\StaffCustomer();
                    $staffCustomer->staff_wp_id = $wp_staff_id;
                    $staffCustomer->customer_id = $data['customer_id'];
                    $staffCustomer->created_date = $data['appointment_date'];
                    $staffCustomer->comment = $data['medical_comment'];
                    $staffCustomer->save();
                    
                }
        }
     
        wp_send_json($response   );
    }

    
    
        /**
     * Get list of customers.
     */
    public function executeSaveAppointmentDetail()
    {
        global $wpdb;
        $response = array();
        $data = $this->getParameter( 'data' );
        
        $wp_staff_id = get_current_user_id();
        
        $staffCustomer = new Lib\Entities\StaffCustomer();
        $staffCustomer->load($data['customer_staff_id']);
        
        if($staffCustomer->isLoaded()) {
             $staffCusDetail = new Lib\Entities\StaffCustomerDetail();
             $staffCusDetail->medical_id =  $staffCustomer->getId();
             $staffCusDetail->image = $data['stl_link'];
             $staffCusDetail->comment = $data['medical_comment'];
             $staffCusDetail->created_date = date('Y-m-d H:m:s', current_time( 'timestamp' ) );
             $staffCusDetail->save();
            $response['success']  = true;
            
        } else {
                 $response['success']  = false;
        }
        
        
       

        wp_send_json($response   );
    }
    
    
    
    
 /**
     * Get list of customers.
     */
    public function executeGetPatients()
    {
        global $wpdb;

        $columns = $this->getParameter( 'columns' );
        $order   = $this->getParameter( 'order' );
        $filter  = $this->getParameter( 'filter' );
        $wp_staff_id = get_current_user_id();
        $query = Lib\Entities\StaffCustomer::query( 'sc' );

        $total = $query->count();

        $query
            ->select( '
                sc.id,c.full_name,c.phone,c.email,sc.comment,sc.created_date ,c.birthday,
                ( SELECT COUNT(scd.id) FROM ' . Lib\Entities\StaffCustomerDetail::getTableName() . ' AS scd WHERE sc.id = scd.medical_id )
                AS total_pictures
                
                ' )
              ->leftJoin('Customer', 'c', 'c.id = sc.customer_id ')
              ->where('sc.staff_wp_id', $wp_staff_id)  
            ;

        if ( $filter != '' ) {
            $search_value = Lib\Query::escape( $filter );
            $query
                ->whereLike( 'c.full_name', "%{$search_value}%" )
                ->whereLike( 'c.phone', "%{$search_value}%", 'OR' )
                ->whereLike( 'c.email', "%{$search_value}%", 'OR' );
        }

        foreach ( $order as $sort_by ) {
            $query->sortBy( str_replace( '.', '_', $columns[ $sort_by['column'] ]['data'] ) )
                ->order( $sort_by['dir'] == 'desc' ? Lib\Query::ORDER_DESCENDING : Lib\Query::ORDER_ASCENDING );
        }

        $query->limit( $this->getParameter( 'length' ) )->offset( $this->getParameter( 'start' ) );

        $data = array();
        foreach ( $query->fetchArray() as $row ) {
            $data[] = array(
                'id'                 => $row['id'],
                'full_name'          => $row['full_name'],
                'phone'              => $row['phone'],
                'email'              => $row['email'],
                'notes'              => $row['comment'],
                'birthday'           => $row['birthday'],
                'created_date'   => $row['created_date'] ,
                'total_pictures' => $row['total_pictures']
            );
        }

        wp_send_json( array(
            'draw'            => ( int ) $this->getParameter( 'draw' ),
            'recordsTotal'    => $total,
            'recordsFiltered' => ( int ) $wpdb->get_var( 'SELECT FOUND_ROWS()' ),
            'data'            => $data,
        ) );
    }

/**
     * Delete customers.
     */
    public function executeDeletePatientAppointments()
    {
        foreach ( $this->getParameter( 'data', array() ) as $id ) {
            $staffCustomer = new Lib\Entities\StaffCustomer();
            $staffCustomer->load( $id );
           $staffCustomer->delete();
        }
        wp_send_json_success();
    }



  

    

}