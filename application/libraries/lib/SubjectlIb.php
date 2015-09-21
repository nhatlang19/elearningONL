<?php
use App\Libraries\AppComponent;

require_once APPPATH . 'libraries/components/AppComponent.php';

class Subjectlib extends AppComponent {
    function __construct()
    {
        parent::__construct();
        
        $this->CI->load->library([
            'form_validation'
        ]);
    }
    
    public function validate(array $data) {
        $this->CI->form_validation->set_data($data);
        
        $this->CI->form_validation->set_rules(
            'subjects_name', 
            'Tên môn học', 
            'required|min_length[4]|max_length[255]',
            array(
                'required' => 'Tên môn học không được rỗng',
                'min_length' => 'Tên môn học ít nhất phải có {param} ký tự',
                'max_length' => 'Tên môn học phải nhỏ hơn {param} ký tự'
            )
        );
        
        return $this->CI->form_validation->run();
    }
}