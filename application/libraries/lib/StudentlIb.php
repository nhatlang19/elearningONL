<?php
use App\Libraries\AppComponent;

require_once APPPATH . 'libraries/components/AppComponent.php';

class Studentlib extends AppComponent {
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
            'indentity_number',
            'Mã số học sinh',
            'required|min_length[4]|max_length[255]',
            array(
                'required' => 'Mã số học sinh không được rỗng',
                'min_length' => 'Mã số học sinh ít nhất phải có {param} ký tự',
                'max_length' => 'Mã số học sinh phải nhỏ hơn {param} ký tự'
            )
        );
        
        $this->CI->form_validation->set_rules(
            'fullname', 
            'Họ tên', 
            'required|min_length[8]|max_length[255]',
            array(
                'required' => 'Họ tên không được rỗng',
                'min_length' => 'Họ tên ít nhất phải có {param} ký tự',
                'max_length' => 'Họ tên phải nhỏ hơn {param} ký tự'
            )
        );
    
        return $this->CI->form_validation->run();
    }
}