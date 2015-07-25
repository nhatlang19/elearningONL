<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'helpers/Traits/TemplateTrait.php';
class Users extends CI_Controller
{
    use TemplateTrait;
    use PaginateTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user', TRUE);
        $this->load->model('subject_model');
    }

    function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(BACKEND_V2_TMPL_PATH . 'storage');
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
            
            $newdata = array(
                'error_change' => 'Mật khẩu không trùng nhau'
            );
            
            $this->session->set_userdata($newdata);
        } else {
            // update status
            $newdata = array(
                'success_change' => 'Đã cập nhật thành công'
            );
            $this->session->set_userdata($newdata);
            
            $user = $this->session->userdata('user');
            
            // update password into db
            $this->user->update_password($user->username, $pass);
            
            // update password into session
            // $user->password = $pass;
            // $newdata = array(
            // 'user' => $user,
            // 'logged_in' => TRUE
            // );
            // $this->session->set_userdata ( $newdata );
        }
        
        // redirect to change password page
        redirect(BACKEND_V2_TMPL_PATH . 'users/change_password');
    }

    function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(BACKEND_V2_TMPL_PATH . 'storage/lists');
        }
        $data = ['username' => ''];
        if ($this->input->post()) {
            
            $username = addslashes($this->input->post('username'));
            $password = $this->input->post('password');
            $user = $this->user->get_user($username, $password);
            
            if ($user) {
                $newdata = array(
                    'user' => $user,
                    'logged_in' => TRUE
                );
                $_SESSION['islogin'] = TRUE;
                $this->session->set_userdata($newdata);
                
                redirect(BACKEND_V2_TMPL_PATH . 'storage/lists');
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
        

        $base_url = base_url() . BACKEND_V2_TMPL_PATH . 'storage/lists';
        $config = $this->configPagination($base_url, $this->user->table_record_count, $per_page, 4);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'users/lists', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    function edit($id = null)
    {
        $header['title'] = 'Thêm User';
        $task = 'add';
        $data = array();
        if ($id) {
            $header['title'] = 'Chỉnh sửa user';
            $data['userInfo'] = $this->user->find_by_pkey($id);
            $data['id'] = $id;
            $task = 'edit';
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data['username'] = $this->input->post('username');
            $data['password'] = $this->input->post('password');
            $data['email'] = $this->input->post('email');
            $data['subjects_id'] = $this->input->post('subjects_id');
            $data['published'] = 1;
            $data['role'] = 10;
            
            if (! $id) {
                // save into user table
                $data['password'] = md5($data['password']);
                $this->user->create($data);
            } else {
                if (! is_null($data['password']) && $data['password'])
                    $data['password'] = md5($data['password']);
                else
                    unset($data['password']);
                $this->user->update_by_pkey($id, $data);
            }
            unset($data);
            
            redirect(BACKEND_V2_TMPL_PATH . 'users/lists');
        }
        
        $data['title'] = $header['title'];
        $data['task'] = $task;
        $data['subjects'] = $this->subject_model->getAllSubjects();
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'users/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }
}
