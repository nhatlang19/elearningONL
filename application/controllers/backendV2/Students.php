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
        $this->load->model('academic_model');
        
        $this->load->library([
            'lib/studentlib', 'commonobj'
        ]);
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
        
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data = $this->input->post();
            $data['indentity_number'] = sanitizeText($data['indentity_number']);
            $data['fullname'] = sanitizeText($data['fullname']);
            $data['username'] = $this->commonobj->encrypt($data['academic_id'] . '_' . $data['class_id'] . '_' . $data['indentity_number']);
            $data['password'] = $this->commonobj->encrypt($data['username']);
            $data['academic_id'] = (int) $data['academic_id'];
            
            $isValid = $this->studentlib->validate($data);
            if($isValid) {
                unset($data['id']);
                if (! $id) {
                    // save into subject table
                    $this->student_info_model->create($data);
                } else {
                    $this->student_info_model->update_by_pkey($id, $data);
                }
                unset($data);
                
                redirect(BACKEND_V2_TMPL_PATH . 'students/lists');
            }
        }
        
        if ($id) {
            $header['title'] = EDIT_STUDENT;
            $data['student'] = $this->student_info_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        
        $data['classes'] = $this->class_model->getAll();
        
        $data['academics'] = $this->academic_model->getAll();
        
        if(empty($data['academics'])) {
            $this->session->set_flashdata('error', 'Vui lòng tạo niên khoá');
        } else if(empty($data['classes'])) {
            $this->session->set_flashdata('error', 'Vui lòng tạo lớp');
        } 
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
                    $academic_id = intval($this->input->post('academic_id'));
                    if ($class_id && $academic_id) {
                        $this->_saveFileData($class_id, $academic_id, $file['name']);
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
        $data['academics'] = $this->academic_model->getAll();
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'students/import', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    private function _saveFileData($class_id, $academic_id, $fileName)
    {
        $uploadpath = 'public/backendV2/tmp/' . $fileName;
        
        $columns = array(
            '',
            'A',
            'B'
        );
		
        $this->load->library('utils');
        $sheetData = $this->utils->oleExcelReader($uploadpath, false);
        if (count($sheetData)) {
            unset($sheetData[1]); // delete title
            
            $lists = array();
            foreach ($sheetData as $key => $col) {
                $data = array();
                $data['indentity_number'] = sanitizeText($col['A']);
                $data['class_id'] = (int) $class_id;
                $data['academic_id'] = (int) $academic_id;
                $data['fullname'] = sanitizeText($col['B']);
                $data['username'] = $this->commonobj->encrypt($academic_id . '_' . $class_id . '_' . sanitizeText($col['A']));
                $data['password'] = $this->commonobj->encrypt($data['username']);
                if(empty($data['indentity_number']) || empty($data['fullname'])) {
                    continue;
                }
                $this->student_info_model->create_ignore($data);
            }
        }
        
        @unlink($uploadpath);
    }
    
    public function login_list() {
        $header['title'] = 'Danh sách học sinh đang đăng nhập';
        
        $data['title'] = $header['title'];
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'students/login_list', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }
}