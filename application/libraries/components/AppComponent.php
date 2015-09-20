<?php
namespace App\Libraries;

abstract class AppComponent {
    protected $CI;
    
    function __construct()
    {
        $this->CI = & get_instance();
    }
}
