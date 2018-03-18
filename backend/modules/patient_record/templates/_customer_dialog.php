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
                    <label for="wp_user"><?php _e( 'Select your customer', 'bookly' ) ?></label>
                    <select class="form-control" id="ah_customer_id">
                        <option value=""></option>
                        <?php foreach ($customers as $customer ) : ?>
                            <option value="<?php echo $customer['id'] ?>">
                                <?php echo $customer['full_name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="birthday"><?php _e( 'Appointment date', 'bookly' ) ?></label>
                    <input class="form-control" type="text" id="appointment_date"   ui-date="dateOptions" ui-date-format="yy-mm-dd" autocomplete="off" />
                </div>
                
                <div class="form-group">
                    <label>Comment</label>
                    <textarea class="form-control"  cols="40" rows="5" id="medical_comment">
                        
                    </textarea>
                    
                </div>
                
            </div>
            <div class="modal-footer">
               
                    <button type="button" class="btn btn-primary" id="save-patient-record">Save record</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
