<?php
namespace Bookly\Lib\Entities;

use Bookly\Lib;

/**
 * Class Staff
 * @package Bookly\Lib\Entities
 */
class StaffCustomerDetail extends Lib\Base\Entity
{
   

    protected static $table = 'ah_staff_customer_detail';

    protected static $schema = array(
        'id'                 => array( 'format' => '%d' ),
        'medical_id'         => array( 'format' => '%d' ),
        'image'      => array( 'format' => '%s' ), 
        'comment'=> array( 'format' => '%s' ), 
        'created_date'           => array( 'format' => '%s' ),
    );

    

}