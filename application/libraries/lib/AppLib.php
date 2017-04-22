<?php
namespace App\Libraries\Lib;

public abstract class AppLib {
    protected $CI;

    function __construct()
    {
        $this->CI = & get_instance();
    }
}
