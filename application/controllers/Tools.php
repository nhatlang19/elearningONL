<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tools extends Ext_Controller {
    public function __construct()
    {
        parent::__construct();
    }
    
    public function message()
    {
        echo 123;
    }
}