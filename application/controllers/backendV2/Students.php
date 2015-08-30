<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Students extends Ext_Controller
{
    protected $mainModel = 'student_info_model';
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('student_info_model');
        $this->load->model('class_model');
        
        $this->load->library('commonobj');
    }

    function lists()
    {
        $header['title'] = MANAGE_STUDENT;
        
        // get data
        $class_id = $this->input->post('class_id', -1);
        
        $data = [];
        $data['lists'] = $this->student_info_model->getAllStudents($class_id);
        $data['classes'] = $this->class_model->getAll();
        $data['class_id'] = $class_id;
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'students/lists', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = ADD_STUDENT;
        
        $data = array();
        if ($id) {
            $header['title'] = EDIT_STUDENT;
            $data['student'] = $this->student_info_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = $this->input->post();
            
            if (! $id) {
                unset($data['id']);
                
                $data['password'] = $this->commonobj->encrypt($data['password']);
                // save into subject table
                $this->student_info_model->create($data);
            } else {
                $this->student_info_model->update_by_pkey($id, $data);
            }
            unset($data);
            
            redirect(BACKEND_V2_TMPL_PATH . 'students/lists');
        }
        
        $data['classes'] = $this->class_model->getAll();
        $data['title'] = $header['title'];
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'students/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    function import()
    {
        $header['title'] = IMPORT_STUDENT;
        
        $data['error'] = '';
        if ($this->input->post()) {
            $file = $_FILES['uploadfile'];
            $error = null;
            if($file['error']) {
                $error = 'File không hợp lệ';
            }
            
            $mimes = get_mimes();
            if(!$error && !in_array($file['type'], $mimes['xls'])) {
                $error = 'File phải là xls';
            }
            
            // need to check filesize more
            
            if(!$error) {
                $filename = BACKEND_V2_TMP_PATH_ROOT . basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $filename)) {
                    $class_id = intval($this->input->post('class_id'));
                    if ($class_id) {
                        $this->_saveFileData($class_id, $file['name']);
                        redirect(BACKEND_V2_TMPL_PATH . 'students/lists');
                    }
                } else {
                    $data['error'] = "Không thể upload file";
                }
            } else {
                $data['error'] = $error;
            }
        }
        $data['title'] = $header['title'];
        $data['classes'] = $this->class_model->getAll();
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'students/import', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    private function _saveFileData($class_id, $fileName)
    {
        $uploadpath = 'public/backendV2/tmp/' . $fileName;
        
        $columns = array(
            '',
            'A',
            'B'
        );
        
        $this->load->library('utils');
        $sheetData = $this->utils->ole_excel_reader($uploadpath, false);
        if (count($sheetData)) {
            // get Class Name
            $col = $sheetData[1];
            $className = $col['B'];
            unset($sheetData[1]);
            
            unset($sheetData[2]); // delete title
            $lists = array();
            foreach ($sheetData as $key => $col) {
                $data = array();
                $data['indentity_number'] = $this->commonobj->TrimAll(addslashes($col['A']));
                $data['class_id'] = (int) $class_id;
                $data['fullname'] = $this->commonobj->TrimAll($col['B']);
                $data['username'] = $className . '_' . $this->commonobj->TrimAll($col['A']);
                $data['password'] = $this->commonobj->encrypt($className . '_' . $col['A']);
                $this->student_info_model->create_ignore($data);
            }
        }
        
        @unlink($uploadpath);
    }
}