<?php
namespace Bookly\Frontend\Modules\CancellationConfirmation;

use Bookly\Lib;

/**
 * Class Controller
 * @package Bookly\Frontend\Modules\CancellationConfirmation
 */
class Controller extends Lib\Base\Controller
{
    public function renderShortCode( $attributes )
    {
        global $sitepress;

        // Disable caching.
        Lib\Utils\Common::noCache();

        $assets = '';

        if ( get_option( 'bookly_gen_link_assets_method' ) == 'print' ) {
            if ( ! wp_script_is( 'bookly-cancellation-confirmation', 'done' ) ) {
                ob_start();

                // The styles and scripts are registered in Frontend.php
                wp_print_styles( 'bookly-cancellation-confirmation' );
                wp_print_scripts( 'bookly-cancellation-confirmation' );

                $assets = ob_get_clean();
            }
        }

        // Prepare URL for AJAX requests.
        $ajax_url = admin_url( 'admin-ajax.php' );

        $token = $this->getParameter( 'bookly-appointment-token', '' );

        return $assets . $this->render( 'short_code', compact( 'ajax_url', 'token' ), false );
    }
}