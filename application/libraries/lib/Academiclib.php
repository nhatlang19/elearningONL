<?php
use App\Libraries\AppComponent;

require_once APPPATH . 'libraries/components/AppComponent.php';

class Academiclib extends AppComponent {
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
            'academic_name', 
            'Niên khoá', 
            'required|min_length[4]|max_length[255]',
            array(
                'required' => 'Niên khoá không được rỗng',
                'min_length' => 'Niên khoá ít nhất phải có {param} ký tự',
                'max_length' => 'Niên khoá phải nhỏ hơn {param} ký tự'
            )
        );
        
        return $this->CI->form_validation->run();
    }
}