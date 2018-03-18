<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div id="bookly-tbs" class="wrap">
    <div class="bookly-tbs-body">
        <div class="page-header text-right clearfix">
            <div class="bookly-page-title">
                <?php _e( 'Patient Record', 'bookly' ) ?>
            </div>
            <?php //\Bookly\Backend\Modules\Support\Components::getInstance()->renderButtons( $this::page_slug ) ?>
        </div>
        <div class="panel panel-default bookly-main">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
<!--                            <input class="form-control" type="text" id="bookly-filter" placeholder="<?php esc_attr_e( 'Quick search customer', 'bookly' ) ?>" />-->
                            <a class="btn btn-success" href="<?php echo admin_url( 'admin.php?page=bookly-patient-record'); ?> ">
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8  form-inline bookly-margin-bottom-lg  text-right">
                       
                        <div class="form-group">
                            <button type="button" class="btn btn-success bookly-btn-block-xs" id="bookly-add" data-toggle="modal" data-target="#bookly-customer-dialog"><i class="glyphicon glyphicon-plus"></i> <?php _e( 'New STL File', 'bookly' ) ?></button>
                        </div>
                    </div>
                </div>
                
                
            <div class="row">
                    <div class="col-md-8 col-md-offset-3">
                       
                        <?php 
                                                         
                                                            if($curentStaffCustomerDetail != null ) {
                                                                    $attr = array();
                                                                    $attr['objPath'] =  $curentStaffCustomerDetail['image'];//$value['image'];
                                                                    $attr['width'] = 320;    $attr['height'] = 320;
                                                                    $attr['border'] = 1;   $attr['borderCol'] = '#F6F6F6';
                                                                    $attr['dropShadow'] = 0;$attr['backCol'] = "#600900";
                                                                    $attr['backImg'] = '';    $attr['mouse'] = "on"; 
                                                                     $attr['rollMode'] = "off"; $attr['rollSpeedH'] = "0"; 
                                                                     $attr['rollSpeedV'] = "0";$attr['objScale'] = "1.5";
                                                                     $attr['objColor'] = "#9c8383"; $attr['lightSet'] = "7";
                                                                     $attr['reflection'] = "off"; $attr['refVal'] = "5";
                                                                     $attr['objShadow'] = "off"; $attr['floor'] = "off" ;
                                                                     $attr['floorHeight'] = "42";$attr['lightRotate'] = "off";
                                                                     $attr['vector'] = "off";$attr['mousewheel'] = "on";$attr['Help'] = "off";


                                                                  echo '<div  class="row form-group" >'        ; 
                                                                   echo      \Bookly\Backend\Modules\PatientRecord\Components::getInstance()->caInitHandler($attr);
                                                                  echo '</div>';
                                                                
                                                                
                                                            } else {
                                                                echo "There is no STL file. Please upload one.";
                                                            }

                                                                
                                                               ?>
                        <div  class="row" >
                            <label > Doctor comment:</label>
                            <p > <?php echo  $curentStaffCustomerDetail['comment']; ?></p>
                        </div>
                        <div class="row">
                    <?php
                                                     
                                                           foreach ( $staffCustomerDetails as $key => $value) {
                                                               $link = $url.'&p='.$key;
                                                               $np = $key+1;
                                                                echo '<a class=" paging-btn  btn btn-primary" href="'.$link.'">'. $np . '</a>';
                                                           }
                    
                                                ?>
                            </div>
                    </div>
                </div>
                
                    
                    
                
                
                
                
            </div>
        </div>

       

        <div >
           
            <?php \Bookly\Backend\Modules\PatientRecord\Components::getInstance()->renderDetailDialog() ?>
        </div>
    </div>
</div>

<style>
    .paging-btn {
        margin-left: 5px;
    }
</style>