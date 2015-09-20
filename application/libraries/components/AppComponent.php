<?php
namespace App\Libraries;

abstract class AppComponent {
    protected $CI;
    
    public $validateMessages = array();
    
    function __construct()
    {
        $this->CI = & get_instance();
    }
}
