<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('academic_model');
        $this->load->model('class_model');
        $this->load->model('block_model');
        $this->load->model('subject_model');
    }

    function index()
    {
        $header['title'] = 'Dashboard';
        
        $stats['academic'] = !$this->academic_model->getMaxId() ? ['message' => 'Niên khoá chưa được tạo', 'uri' => BACKEND_V2_TMPL_PATH. 'academic/lists'] : [];
        $stats['class'] = !$this->class_model->getMaxId() ? ['message' => 'Lớp chưa được tạo', 'uri' => BACKEND_V2_TMPL_PATH . 'clazz/lists'] : [];
        $stats['block'] = !$this->block_model->getMaxId() ? ['message' => 'Khối chưa được tạo', 'uri' => BACKEND_V2_TMPL_PATH. 'block/lists'] : [];
        $stats['subject'] = !$this->subject_model->getMaxId() ? ['message' => 'Môn học chưa được tạo', 'uri' => BACKEND_V2_TMPL_PATH . 'subject/lists'] : [];
        
        
        $data = array();
        $data['stats'] = $stats;
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'dashboard/index', $data, TRUE);
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
            $file = BACKEND_V2_TMP_PATH_ROOT . basename($_FILES['uploadfile']['name']);
            if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
                
                // empty all tables
                $this->load->library('mybackup');
                $this->mybackup->_dropTables();
                
                // import db
                $this->_saveFileData($class_id, $_FILES['uploadfile']['name']);
                redirect(BACKEND_V2_TMPL_PATH . 'dashboard/index');
            } else {
                $data['error'] = "Không thể upload file";
            }
        }
        $data['title'] = $header['title'];
        $data['classes'] = $this->class_model->getAllClass();
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'dashboard/import_db', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    private function _saveFileData($class_id, $fileName)
    {
        $uploadpath = BACKEND_V2_TMP_PATH_ROOT . $fileName;
        
        @unlink($uploadpath);
    }
    
    
}