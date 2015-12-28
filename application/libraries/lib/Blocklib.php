<?php
use App\Libraries\AppComponent;

require_once APPPATH . 'libraries/components/AppComponent.php';

class Blocklib extends AppComponent {
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
            'title', 
            'Tên khối', 
            'required|min_length[2]|max_length[255]',
            array(
                'required' => 'Tên khối không được rỗng',
                'min_length' => 'Tên khối ít nhất phải có {param} ký tự',
                'max_length' => 'Tên khối phải nhỏ hơn {param} ký tự'
            )
        );
        
        return $this->CI->form_validation->run();
    }
}