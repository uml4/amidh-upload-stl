<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Bookly\Lib;

/**
 * Description of ResponeRequest
 *
 * @author Owner
 */
class HttpRespone {
    
    const CODE_401 = 401;
    const CODE_404 = 404;
    const CODE_200 = 200;
    const CODE_201 = 201;
    const CODE_500 = 500;
    const CODE_400 = 400;

    public $code;
    public $body = array();
    public $error_message; 
    
    
    
}
