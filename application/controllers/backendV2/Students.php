<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * class student
 * 
 * @author nhox
 *        
 *        
 */
class Students extends Ext_Controller
{

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
        $per_page = PER_PAGE;
        $class_id = $this->input->post('class_id');
        $name = $this->input->post('name');
        $data = array();
        
        $segment = $this->uri->segment(self::_URI_SEGMENT);
        $base_url = base_url() . BACK_END_TMPL_PATH . 'students/lists';
        
        $data['lists'] = $this->student_info_model->getAllStudents($name, $class_id, $segment, $per_page);
        $config = $this->configPagination($base_url, $this->student_info_model->table_record_count, $per_page, self::_URI_SEGMENT);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $data['classes'] = $this->class_model->getAllClass();
        $data['class_id'] = $class_id;
        $data['name'] = $name;
        $content = $this->load->view(BACK_END_TMPL_PATH . 'students/lists', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = ADD_STUDENT;
        $task = 'add';
        
        $data = array();
        if ($id) {
            $header['title'] = EDIT_STUDENT;
            $data['student'] = $this->student_info_model->find_by_pkey($id);
            $data['id'] = $id;
            $task = 'edit';
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = $this->input->post();
            $data['password'] = $this->commonobj->encrypt($data['password']);
            if (! $id) {
                unset($data['id']);
                unset($data['task']);
                // save into subject table
                $this->student_info_model->create($data);
            } else {
                $this->student_info_model->update_by_pkey($id, $data);
            }
            unset($data);
            
            redirect(BACK_END_TMPL_PATH . 'students/lists');
        }
        
        $data['classes'] = $this->class_model->getAllClass();
        $data['title'] = $header['title'];
        $data['task'] = $task;
        $content = $this->load->view(BACK_END_TMPL_PATH . 'students/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    function import()
    {
        $header['title'] = IMPORT_STUDENT;
        $data['error'] = '';
        if ($this->input->post()) {
            $file = BACK_END_TMP_PATH_ROOT . basename($_FILES['uploadfile']['name']);
            if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
                $class_id = intval($this->input->post('class_id'));
                if ($class_id) {
                    $this->_saveFileData($class_id, $_FILES['uploadfile']['name']);
                    redirect(BACK_END_TMPL_PATH . 'students/lists');
                }
            } else {
                $data['error'] = "Không thể upload file";
            }
        }
        $data['title'] = $header['title'];
        $data['classes'] = $this->class_model->getAllClass();
        $content = $this->load->view(BACK_END_TMPL_PATH . 'students/import', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    private function _saveFileData($class_id, $fileName)
    {
        $uploadpath = 'public/backend/tmp/' . $fileName;
        
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
                $data['class_id'] = $class_id;
                $data['fullname'] = $this->commonobj->TrimAll($col['B']);
                $data['username'] = $className . '_' . $this->commonobj->TrimAll($col['A']);
                $data['password'] = $this->commonobj->encrypt($className . '_' . $col['A']);
                $this->student_info_model->create_ignore($data);
            }
        }
        
        @unlink($uploadpath);
    }
}