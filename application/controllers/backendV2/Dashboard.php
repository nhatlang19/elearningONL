<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $header['title'] = 'Dashboard';
        
        $data = array();
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'dashboard/index', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    function backup()
    {
        $this->load->library('mybackup');
        $this->mybackup->_do();
    }

    function drop_table()
    {
        $this->load->library('mybackup');
        $this->mybackup->_dropTables();
    }

    function import_db()
    {
        $header['title'] = 'Import database';
        $data['error'] = '';
        if ($this->input->post()) {
            $file = BACK_END_TMP_PATH_ROOT . basename($_FILES['uploadfile']['name']);
            if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
                
                // empty all tables
                $this->load->library('mybackup');
                $this->mybackup->_dropTables();
                
                // import db
                $this->_saveFileData($class_id, $_FILES['uploadfile']['name']);
                redirect(BACK_END_TMPL_PATH . 'dashboard/index');
            } else {
                $data['error'] = "Không thể upload file";
            }
        }
        $data['title'] = $header['title'];
        $data['classes'] = $this->class_model->getAllClass();
        $content = $this->load->view(BACK_END_TMPL_PATH . 'dashboard/import_db', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    private function _saveFileData($class_id, $fileName)
    {
        $uploadpath = BACK_END_TMP_PATH_ROOT . $fileName;
        
        @unlink($uploadpath);
    }
}