<?php
use App\Libraries\AppComponent;

require_once APPPATH . 'libraries/components/AppComponent.php';

class Topiclib extends AppComponent {
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
            'Tiêu đề', 
            'required|min_length[4]|max_length[255]',
            array(
                'required' => 'Tiêu đề không được rỗng',
                'min_length' => 'Tiêu đề ít nhất phải có {param} ký tự',
                'max_length' => 'Tiêu đề phải nhỏ hơn {param} ký tự'
            )
        );
        
        $this->CI->form_validation->set_rules(
            'number_question',
            'Số lượng câu hỏi',
            'required|is_natural_no_zero',
            array(
                'required' => 'Số lượng câu hỏi không được rỗng',
                'is_natural_no_zero' => 'Số lượng câu hỏi phải là 1 số nguyên khác 0'
            )
        );
        
        $this->CI->form_validation->set_rules(
            'number_topic',
            'Số lượng đề thi',
            'required|is_natural_no_zero',
            array(
                'required' => 'Số lượng đề thi không được rỗng',
                'is_natural_no_zero' => 'Số lượng đề thi phải là 1 số nguyên khác 0'
            )
        );
        
        return $this->CI->form_validation->run();
    }
}