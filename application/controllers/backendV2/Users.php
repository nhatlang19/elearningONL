<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'helpers/Traits/TemplateTrait.php';
include_once APPPATH . 'helpers/Traits/PaginateTrait.php';
include_once APPPATH . 'helpers/Traits/ManageRoleTrait.php';
class Users extends CI_Controller
{
    use TemplateTrait;
    use PaginateTrait;
    use ManageRoleTrait; 
    
    public function __construct()
    {
        parent::__construct();
        
        
        if ($this->session->userdata('logged_in')) {
            // check permission
            $allowActions = array('index', 'change_password', 'login', 'logout');
            if(!$this->allowPermissions($allowActions)) {
                $this->session->set_flashdata('error', 'Bạn không có quyền truy cập');
                redirect(BACKEND_V2_TMPL_PATH . 'dashboard');
            }
        }
        
        $this->load->model('User_model', 'user', TRUE);
        $this->load->model('subject_model');
        
        $this->load->library([
            'lib/userlib', 'utils'
        ]);
    }

    function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(BACKEND_V2_TMPL_PATH . 'dashboard');
        } else {
            redirect('admin/signin');
        }
    }

    function change_password()
    {
        if (! $this->session->userdata('logged_in')) {
            redirect(BACKEND_V2_TMPL_PATH . 'users');
        }
        
        $header['title'] = 'Change Password';
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'users/change_password', null, TRUE);
        
        $this->loadTemnplateBackend($header, $content);
    }

    function save()
    {
        if (! $this->session->userdata('logged_in')) {
            redirect(BACKEND_V2_TMPL_PATH . 'users');
        }
        
        $pass = $this->input->post('pass');
        $confirm_pass = $this->input->post('re-pass');
        
        if ((! $pass || ! $confirm_pass) || $pass != $confirm_pass) {
            $this->session->set_flashdata('error', 'Mật khẩu không trùng nhau');
        } else {
            // update status
            $this->session->set_flashdata('success', 'Cập nhật thành công');
            
            $user = $this->session->userdata('user');
            
            // update password into db
            $this->user->update_password($user->username, $pass);
        }
        
        // redirect to change password page
        redirect(BACKEND_V2_TMPL_PATH . 'users/change_password');
    }

    function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(BACKEND_V2_TMPL_PATH . 'dashboard');
        }
        $data = ['username' => ''];
        if ($this->input->post()) {
            
            $username = addslashes($this->input->post('username'));
            $password = $this->input->post('password');
            $user = $this->user->get_user($username, $password);
            if ($user) {
                $user->ip_address = $this->utils->getLocalIp();
                $newdata = array(
                    'user' => $user,
                    'logged_in' => TRUE
                );
                $_SESSION['islogin'] = TRUE;
                $this->session->set_userdata($newdata);
                
                redirect(BACKEND_V2_TMPL_PATH . 'dashboard');
            } else {
                $this->session->set_flashdata('error', 'Tên đăng nhập / mật khẩu không hợp lệ');
            }
            $data['username'] = $username;
        }
        $this->load->view(BACKEND_V2_TMPL_PATH . 'login', $data);
    }

    function logout()
    {
        if (! $this->session->userdata('logged_in')) {
            redirect('admin/signin');
        }
        unset($_SESSION['islogin']);
        $array_items = array(
            'user', 'logged_in'
        );
        $this->session->unset_userdata($array_items);
        
        unset(
            $_SESSION['user'],
            $_SESSION['logged_in']
        );
        
        redirect('admin/signin');
    }

    function lists()
    {
        if (! $this->session->userdata('logged_in')) {
            redirect('admin/signin');
        }
        $header['title'] = 'Quản lý users';
        
        // get data
        $per_page = PER_PAGE;
        $username = $this->input->post('username');
        $uri_segment = $this->uri->segment(4);
        
        $base_url = base_url() . BACKEND_V2_TMPL_PATH . 'users/lists';
        
        $data['lists'] = $this->user->getAllUser($username, $uri_segment, $per_page);
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'users/lists', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    function edit($username = null)
    {
        $header['title'] = 'Thêm User';
        
        $data = array();
        if ($this->input->post()) {
            $action = $this->input->post('action', 'add');
            $data['fullname'] = sanitizeText($this->input->post('fullname'));
            $data['username'] = sanitizeText($this->input->post('username'));
            $data['password'] = $this->input->post('password');
            $data['email'] = $this->input->post('email');
            $data['subjects_id'] = (int)$this->input->post('subjects_id');
            $data['published'] = 1;
            $data['role'] = 10;
            if ($action != 'add') {
                unset($data['username']);
            }
            
            $isValid = $this->userlib->validate($data, $action);
            if($isValid) {
                if ($action == 'add') {
                    // save into user table
                    $data['password'] = md5($data['password']);
                    $this->user->create($data);
                } else {
                    if (! is_null($data['password']) && $data['password']) {
                        $data['password'] = md5($data['password']);
                    } else {
                        unset($data['password']);
                    }
                    $this->user->update_by_pkey($username, $data);
                }
                unset($data);
                
                redirect(BACKEND_V2_TMPL_PATH . 'users/lists');
            }
            
            $data['userInfo'] = (object)$data;
        }
        
        $action = 'add';
        if ($username) {
            $header['title'] = 'Chỉnh sửa user';
            $data['userInfo'] = $this->user->find_by_pkey($username);
            $action = 'edit';
        }
        
        $data['action'] = $action;
        $data['title'] = $header['title'];
        $data['subjects'] = $this->subject_model->getAll();
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'users/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }
    
    public function delete($username = null) {
        if($this->input->is_ajax_request() && !empty($username)) {
            $id = sanitizeText($username);
            $this->user->update_by_pkey($id, ['deleted' => DELETED_YES, 'username' => $username . '_' . date('YmdHis') . uniqid()]);
            
            $response = [
                'status' => 0,
                'message' => ''
            ];
            
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            
        } else {
            show_404();
        }
    }
}
