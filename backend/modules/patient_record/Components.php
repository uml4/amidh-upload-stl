<?php
namespace Bookly\Backend\Modules\PatientRecord;

use Bookly\Lib;

/**
 * Class Components
 * @package Bookly\Backend\Modules\Customers
 */
class Components extends Lib\Base\Components
{
    /**
     * Render customer dialog.
     * @throws \Exception
     */
    public function renderRecordDialog()
    {
        global $wp_locale;

      

        //get all customer  
        $customers = Lib\Entities\Customer::query( 'c' )->fetchArray();
        $this->render( '_customer_dialog', array('customers' => $customers) );
    }
    
    public function renderDetailDialog()
    {
        global $wp_locale;

      
           $sc =  $_GET['sc'] ;
        //get all customer  
        $customers = Lib\Entities\Customer::query( 'c' )->fetchArray();
        $this->render( '_customer_detail_dialog', array('customers' => $customers ,'sc' =>$sc) );
    }
    
    
    function caInitHandler( $atts  ){
		$defaults=array(
			'loadingtext'=>'Loading ...',
			'vector'=>'off',
			'mousewheel'=>'on',
			'backimg'=>'',
			'reflection'=>'',
			'refval'=>'0',
			'floor'=>'off',
			'floorheight'=>'42',
			'objpath'=>'',
			'texturpath'=>'',
			'envtexturpath'=>'',
			'objcol'=>'',
			'objcolor'=>'#9c8383',
			'objscale'=>'1',
			'objshadow'=>'off',
			'width'=>'220',
			'height'=>'220',
			'dropshadow'=>'0',
			'zoom'=>'50',
			'textcol'=>'#000000',
			'border'=>'0',
			'bordercol'=>'#f6f6f6',
			'backcol'=>'#ffffff',
			'text'=>'',
			'rollspeedx'=>'0',
			'rollspeedy'=>'0',
			'rollspeedh'=>'0',
			'rollspeedv'=>'0',			
			'rollmode'=>'',			
			'mouse'=>'',
			'lightset'=>'0',
			'lightrotate'=>'off',
			'shine'=>'0',
			'ambient'=>'#aaa',
			'fps'=>'',
			'wincount'=>'0',
			'_uploadUrl'=>'',
			'_picUrl'=>'',
			'lang'=>'',
			'help'=>'off'
		);
		$flag=array(
			'loadingtext'=>'1',
			'vector'=>'1',
			'mousewheel'=>'1',		
			'reflection'=>'1',
			'backimg'=>'1',
			'refval'=>'0',
			'floor'=>'1',
			'floorheight'=>'0',
			'objpath'=>'1',
			'texturpath'=>'1',
			'envtexturpath'=>'1',
			'width'=>'0',
			'height'=>'0',
			'dropshadow'=>'0',
			'zoom'=>'0',
			'objscale'=>'0',
			'objshadow'=>'1',
			'textcol'=>'1',
			'border'=>'0',
			'bordercol'=>'1',
			'backcol'=>'1',
			'text'=>'1',
			'rollspeedx'=>'0',
			'rollspeedy'=>'0',
			'rollspeedv'=>'0',
			'rollspeedh'=>'0',			
			'rollmode'=>'1',			
			'mouse'=>'1',
			'lightset'=>'0',
			'lightrotate'=>'1',
			'shine'=>'0',
			'ambient'=>'1',
			'objcol'=>'1',
			'objcolor'=>'1',
			'fps'=>'1',
			'wincount'=>'0',
			'_uploadUrl'=>'1',
			'_picUrl'=>'1',
			'lang'=>'1',
			'help'=>'1'
		);
		$href=array();
		$temp=array();
		$e=array();
		$a=   shortcode_atts($defaults,$atts);
                                    $a['objpath']= $atts['objPath'];
                                    foreach ($atts as $k=>$v) {
			$href=explode('"',$v); if(sizeof($href)>2)array_push($temp,$href[1]);
			if($k==null){
				$v=str_replace('"','',$v);
				$v=str_replace('»','',$v);
				$v=str_replace('«','',$v);
				$v=str_replace('¨','',$v);
				$v=str_replace('″','',$v);
				$v=str_replace('′','',$v);
				$v=str_replace('=',':',$v);
				$e=explode(":",$v); $a[$e[0]]=$e[1];
			}			
		}
		$a['lang']=get_locale();
		if($a['objpath']=='') $a['objpath']=$temp[0];
                                    
//                                    if($atts['objpath']=='' || $atts['objpath']=='...') {
//			$a['objpath']= $atts['objpath'];
//			//$a['objcolor']='#FF0000';
//		}
                
		if($a['texturpath']=='' && $temp[1]!='') $a['texturpath']=$temp[1];
		if($a['envtexturpath']=='' && $temp[1]!='') $a['envtexturpath']=$temp[1];
		if((int) $a['width'] > 940) $a['width']='940';
		if((int) $a['height'] > 940) $a['height']='940';
		if($a['objpath']=='' || $a['objpath']=='...') {
			$a['objpath']= plugins_url('canvasio3d-light/inc/obj/canvasio3d.stl');
			$a['objcolor']='#FF0000';
		}
                                    
                                    
                            
		if (is_user_logged_in() && $a['help']=='on') {
			$tf=true;
			$msg=array();
			$caError=false;
			if(get_locale()!='de_DE'){
				$msg[0]='Canvasio3D - Entry error at object window: '.$GLOBALS["canvasioId"].'<br>-----------------------------------------------------------<br>';
				$msg[1]='Must be a string: '; $msg[2]='This entry is not numeric: '; $msg[3]='This entry is not a color hex-number: ';$msg[4]='No error found.';
			}else{
				$msg[0]='Canvasio3D - Eingabefehler im Objektfenster: '.$GLOBALS["canvasioId"].'<br>-----------------------------------------------------------<br>';
				$msg[1]='Hier sollte Text stehen: '; $msg[2]='Dieser Eintrag ist keine Zahl: '; $msg[3]='Dieser Eintrag ist kein Hex-Farbwert: ';$msg[4]='Keine Fehler gefunden.';
			}
			foreach ($a as $k=>$v) {				
				if($a[$k]!=''){
					if (is_numeric($v)) {
						if($flag[$k]!='0'){
							if(!$tf){$tf=true; echo $msg[0];}
							if($k=='textcol' || $k=='bordercol' || $k=='backcol' || $k=='ambient'){
								echo $msg[3].$k.'='.'"'.$a[$k].'"'.'<br>';
								$caError=true;
							}else{							
								echo $msg[1].$k.'='.'"'.$a[$k].'"'.'<br>';
								$caError=true;
							}
							$a[$k]=$defaults[$k];
						}
					}else{
						if($k=='textcol' || $k=='bordercol' || $k=='backcol' || $k=='ambient'){
							if (strpos($a[$k],'#') === false) {
								echo $msg[3].$k.'='.'"'.$a[$k].'"'.'<br>';
								$caError=true;
							}
						}else{
							if($flag[$k]!='1'){
								if(!$tf){$tf=true; echo $msg[0];}
								echo $msg[2].$k.'='.$a[$k].'<br>';
								$a[$k]=$defaults[$k];
								$caError=true;
							}
						}
					}
				}
			}
			if($tf){if(!$caError)echo($msg[4]);echo '<br><span>More Support: <a href="http:www.canvasio3d.com/forums" target="_blank">Canvasio3D.com</a></span><br><br>';}
		}
		$a['ambient']=str_replace('#','0x',$a['ambient']);
		$a['objcol']=str_replace('#','0x',$a['objcol']);
		$a['objcolor']=str_replace('#','0x',$a['objcolor']);
		$a['_picUrl']=plugins_url();
		$a['_uploadUrl']=content_url().'/uploads/';
		$id=new \stdClass(); $id->{'id'}=$GLOBALS["canvasioId"]; $a['winCount']=$GLOBALS["canvasioId"]; $GLOBALS["canvasioId"]++; $dp=json_encode($a); $dp=str_replace('"',"'",$dp);
		$screenID='3D_'.$GLOBALS["canvasioId"];
		$style  ="'background-color:".$a['backcol'].";";
		$style .="color:".$a['textcol'].";";
		$style .="border:".$a['border']."px solid".";";
		$style .="border-color:".$a['bordercol'].";";
		$style .="width:".$a['width']."px".";";
		$style .="height:".$a['height']."px".";";
		$style .="overflow: hidden;";
		$style .="-moz-box-shadow: 0 0 ".$a['dropshadow']."px #888; -webkit-box-shadow: 0 0 ".$a['dropshadow']."px#888; box-shadow: 0 0 ".$a['dropshadow']."px #888;";	
		$style .="padding:0px".";'";
//		if(id==0){
//			wp_enqueue_script('threejs');
//			wp_enqueue_script('glDetector');
//			wp_enqueue_script('wpWebGL');
//		}
		return '<div class="canvasio3D" style='.$style.'><div id="'.$screenID.'" data-parameter="'.$dp.'"></div></div>';
	}
    

}