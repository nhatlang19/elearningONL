<?php
use App\Libraries\AppComponent;

require_once APPPATH . 'libraries/components/AppComponent.php';

class Userlib extends AppComponent {
    use ExportCsvTrait;
    
    function __construct()
    {
        parent::__construct();
        
        $this->CI->load->library([
            'form_validation'
        ]);
    }
    
    public function validate(array $data, $action = 'add') {
        $this->CI->form_validation->set_data($data);
        
        $this->CI->form_validation->set_rules(
            'fullname', 
            'Họ tên', 
            'required|min_length[10]|max_length[255]',
            array(
                'required' => 'Họ tên không được rỗng',
                'min_length' => 'Họ tên ít nhất phải có {param} ký tự',
                'max_length' => 'Họ tên phải nhỏ hơn {param} ký tự'
            )
        );
        
        if($action == 'add') {
            $this->CI->form_validation->set_rules(
                'username',
                'Tên đăng nhập',
                'required|min_length[6]|max_length[255]|is_unique[users.username]',
                array(
                    'required' => 'Tên đăng nhập không được rỗng',
                    'min_length' => 'Tên đăng nhập ít nhất phải có {param} ký tự',
                    'max_length' => 'Tên đăng nhập phải nhỏ hơn {param} ký tự',
                    'is_unique' => 'Tên đăng nhập đã tồn tại',
                )
            );
        
            $this->CI->form_validation->set_rules(
                'password',
                'Mật khẩu',
                'required|min_length[6]|max_length[255]',
                array(
                    'required' => 'Mật khẩu không được rỗng',
                    'min_length' => 'Mật khẩu ít nhất phải có {param} ký tự',
                    'max_length' => 'Mật khẩu phải nhỏ hơn {param} ký tự'
                )
            );
        }
        
        $this->CI->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email',
            array(
                'required' => 'Email không được rỗng',
                'valid_email' => 'Email không hợp lệ'
            )
        );
    
        return $this->CI->form_validation->run();
    }
}