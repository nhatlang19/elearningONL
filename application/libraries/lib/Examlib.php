<?php
use App\Libraries\AppComponent;

require_once APPPATH . 'libraries/components/AppComponent.php';

class Examlib extends AppComponent {
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
            'Hình thức thi', 
            'required|min_length[4]|max_length[255]',
            array(
                'required' => 'Hình thức thi không được rỗng',
                'min_length' => 'Hình thức thi ít nhất phải có {param} ký tự',
                'max_length' => 'Hình thức thi phải nhỏ hơn {param} ký tự'
            )
        );
        
        $this->CI->form_validation->set_rules(
            'time',
            'Thời gian',
            'required|is_natural_no_zero',
            array(
                'required' => 'Thời gian không được rỗng',
                'is_natural_no_zero' => 'Thời gian phải là 1 số nguyên khác 0'
            )
        );
        
        return $this->CI->form_validation->run();
    }
}