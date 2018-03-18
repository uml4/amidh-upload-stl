<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $color = get_option( 'bookly_app_color', '#f4662f' );
?>
<div id="bookly-tbs" class="bookly-js-cancellation-confirmation">
    <div class="bookly-js-cancellation-confirmation-buttons">
        <a href="<?php echo admin_url( 'admin-ajax.php?action=bookly_cancel_appointment&token=' . $token ) ?>" class="bookly-btn bookly-left bookly-inline-block" style="background: <?php echo $color ?>!important; width: auto" data-spinner-size="40" data-style="zoom-in">
            <span><?php _e( 'Confirm', 'bookly' ) ?></span>
        </a>
        <a href="#" class="bookly-js-cancellation-confirmation-no bookly-btn bookly-inline-block bookly-left bookly-margin-left-md" style="background: <?php echo $color ?>!important; width: auto" data-spinner-size="40" data-style="zoom-in">
            <span><?php _e( 'Cancel', 'bookly' ) ?></span>
        </a>
    </div>
    <div class="bookly-js-cancellation-confirmation-message bookly-row collapse">
        <p class="bookly-bold">
            <?php _e( 'Thank you for being with us', 'bookly' ) ?>
        </p>
    </div>
</div>