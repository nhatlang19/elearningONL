<?php
namespace App\Libraries;

class AppComponent {
    protected $CI;
    
    function __construct()
    {
        $this->_CI = & get_instance();
    }
}
