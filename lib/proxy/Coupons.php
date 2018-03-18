<?php
namespace Bookly\Lib\Proxy;

use Bookly\Lib\Base;

/**
 * Class Coupons
 * Invoke local methods from Coupons add-on.
 *
 * @package Bookly\Lib\Proxy
 *
 * @method static void addBooklyMenuItem() Add 'Coupons' to Bookly menu
 * @see \BooklyCoupons\Lib\ProxyProviders\Local::addBooklyMenuItem()
 *
 * @method static string getPaymentStepHtml( \Bookly\Lib\UserBookingData $userData ) Render frontend coupon
 * @see \BooklyCoupons\Lib\ProxyProviders\Local::getPaymentStepHtml()
 *
 * @method static \BooklyCoupons\Lib\Entities\Coupon findOneByCode( string $code ) Return coupon entity.
 * @see \BooklyCoupons\Lib\ProxyProviders\Local::findOneByCode()
 *
 * @method static array getServiceIds( \BooklyCoupons\Lib\Entities\Coupon $coupon ) Return coupon entity.
 * @see \BooklyCoupons\Lib\ProxyProviders\Local::getServiceIds()
 *
 * @method static void renderAppearance() Render editable coupon.
 * @see \BooklyCoupons\Lib\ProxyProviders\Local::renderAppearance()
 *
 * @method static void renderSettings() Render add-on settings
 * @see \BooklyCoupons\Lib\ProxyProviders\Local::renderSettings()
 *
 * @method static array prepareDetails( array $details, $coupon ) Add info about coupon
 * @see \BooklyCoupons\Lib\ProxyProviders\Local::prepareDetails()
 */
abstract class Coupons extends Base\ProxyInvoker
{

}