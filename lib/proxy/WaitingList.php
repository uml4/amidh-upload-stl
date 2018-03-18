<?php
namespace Bookly\Lib\Proxy;

use Bookly\Lib;

/**
 * Class WaitingList
 * Invoke local methods from Waiting List add-on.
 *
 * @package Bookly\Lib\Proxy
 *
 * @method static void handleParticipantsChange( Lib\Entities\Appointment $appointment ) Handle the change of participants of given appointment
 * @see \BooklyWaitingList\Lib\ProxyProviders\Local::handleParticipantsChange()
 *
 * @method static array prepareNotificationCodesList( array $codes, string $set = '' ) Alter array of codes to be displayed in Bookly Notifications.
 * @see \BooklyWaitingList\Lib\ProxyProviders\Local::prepareNotificationCodesList()
 */
abstract class WaitingList extends Lib\Base\ProxyInvoker
{

}