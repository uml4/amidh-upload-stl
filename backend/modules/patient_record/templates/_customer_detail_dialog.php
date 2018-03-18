<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Lib\Utils\Common;
use Bookly\Lib\Config;
?>


<div id="bookly-customer-dialog" class="modal fade" tabindex=-1 role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="modal-title h2"><?php _e( 'New Record', 'bookly' ) ?></div>
            </div>
<!--            <div ng-show=loading class="modal-body">
                <div class="bookly-loading"></div>
            </div>-->
            <div class="modal-body" >
                <div class="form-group">
                    <input type="hidden" id="customer-staff-id" value="<?php echo $sc; ?>" />
                </div>


                <div class="form-group">
                  
                    <div class="text-center avatar"  data-toggle="tooltip" title="Click to upload your customer stl file" >
                        <span>Click to upload your customer stl file</span>  
                        <input  class="form-control button btn-primary" id="upload-button" type="button"  value="Upload file" />
                       
                    </div>
                    <input  class="form-control"  style="width:99% " id="bookly_cus_stl_file_link" value="" type="text">
                    
                </div>
                
                <div class="form-group">
                    <label>Comment</label>
                    <textarea  class="form-control" cols="20" rows="5" id="medical_comment">
                        
                    </textarea>
                    
                </div>
                
            </div>
            <div class="modal-footer">
               
                    <button type="button" class="btn btn-primary" id="save-patient-detail-record">Save record</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
