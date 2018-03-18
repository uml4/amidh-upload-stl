<?php
namespace Bookly\Lib\Entities;

use Bookly\Lib;

/**
 * Class Staff
 * @package Bookly\Lib\Entities
 */
class StaffCustomer extends Lib\Base\Entity
{
   

    protected static $table = 'ah_staff_customer';

    protected static $schema = array(
        'id'                 => array( 'format' => '%d' ),
        'staff_wp_id'         => array( 'format' => '%d' ),
        'customer_id'      => array( 'format' => '%d' ),        
        'comment'=> array( 'format' => '%s' ),
        'created_date'           => array( 'format' => '%s' ),
    );

   

}