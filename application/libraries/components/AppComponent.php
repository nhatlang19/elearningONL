<?php
namespace App\Libraries;

class AppComponent {
    protected $CI;
    
    function __construct()
    {
        $this->CI = & get_instance();
    }
}
