<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * class lớp
 * 
 * @author nhox
 *        
 */
class Index extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('class_model');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }
}

/* End of file storage.php */
/* Location: ./application/controllers/storage.php */