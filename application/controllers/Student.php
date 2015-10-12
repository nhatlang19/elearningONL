<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    
        $this->load->library('commonobj');
        $this->load->model('student_info_model');
        $this->load->model('class_model');
        $this->load->model('academic_model');
    }
    
    public function confirm_info() {
        if (!$this->session->userdata('studentInfo')) {
            redirect('dang-nhap');
        }
        
        $data = $this->session->userdata('studentInfo');
        if(isset($data->confirm) && $data->confirm) {
            redirect('exam/quote');
        }
        if ($this->input->post()) {
            $data->confirm = true;
            $session = array(
                'studentInfo' => $data
            );
            
            $this->session->set_userdata($session);
            redirect('exam/quote');
        }
        $this->load->view(FRONT_END_TMPL_PATH . 'student/confirm_info', $data);
    }
    
    public function login() {
        if ($this->session->userdata('studentInfo')) {
            redirect('exam/quote');
        }

        $data = array();
        if ($this->input->post()) {
            $data = $this->input->post();
            $class_id = (int) $data['class_id'];
            $indentity_number = $this->commonobj->TrimAll($data['indentity_number']);
            if (empty($indentity_number)) {
                $data['error'] = 'Mã số học sinh không hợp lệ';
            } else {
                $academic = $this->academic_model->getDefaultValue();
                $username = $this->commonobj->encrypt($academic->academic_id . '_' . $data['class_id'] . '_' . $data['indentity_number']);
                $password = $this->commonobj->encrypt($username);
                $student = $this->student_info_model->login($username, $password);
                if ($student) {
                    $session = array(
                        'studentInfo' => $student
                    );
                    $this->session->set_userdata($session);
        
                    redirect('xac-nhan-thong-tin');
                } else {
                    $data['error'] = 'Mã số học sinh không hợp lệ';
                }
            }
        }
        
        $data['classes'] = $this->class_model->getAll();
        $this->load->view(FRONT_END_TMPL_PATH . 'student/login', $data);
    }
    
    public function logout() {
        $student = $this->session->userdata('studentInfo');
        $this->session->unset_userdata('studentInfo');
        $student_id = $student->student_id;
        $this->session->unset_userdata('topic_' . $student_id);
        redirect('dang-nhap');
    }
}