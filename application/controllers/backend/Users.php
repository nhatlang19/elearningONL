<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user', TRUE);
        $this->load->model('subject_model');
    }

    function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(BACK_END_TMPL_PATH . 'storage');
        } else {
            redirect('admin/signin');
        }
    }

    function change_password()
    {
        if (! $this->session->userdata('logged_in')) {
            redirect(BACK_END_TMPL_PATH . 'users');
        }
        
        $header['title'] = 'Change Password';
        $content = $this->load->view(BACK_END_TMPL_PATH . 'users/change_password', null, TRUE);
        
        $temp['header'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_header', $header, TRUE);
        $temp['sidebar'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_sidebar', null, TRUE);
        $temp['content'] = $content;
        $temp['footer'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_footer', null, TRUE);
        $this->load->view(BACK_END_TMPL_PATH . 'template', $temp);
    }

    function save()
    {
        if (! $this->session->userdata('logged_in')) {
            redirect(BACK_END_TMPL_PATH . 'users');
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
        redirect(BACK_END_TMPL_PATH . 'users/change_password');
    }

    function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(BACK_END_TMPL_PATH . 'storage/lists');
        }
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
                
                redirect(BACK_END_TMPL_PATH . 'storage/lists');
            } else {
                $newdata = array(
                    'error' => 'Tên đăng nhập / mật khẩu không hợp lệ'
                );
                
                $this->session->set_userdata($newdata);
                redirect('admin/signin');
            }
        }
        $this->load->view(BACK_END_TMPL_PATH . 'login');
    }

    function logout()
    {
        if (! $this->session->userdata('logged_in')) {
            redirect('admin/signin');
        }
        
        unset($_SESSION['islogin']);
        $array_items = array(
            'user' => NULL,
            'logged_in' => ''
        );
        $this->session->unset_userdata($array_items);
        
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
        $data = array();
        
        $uri_segment = $this->uri->segment(4);
        
        $base_url = base_url() . BACK_END_TMPL_PATH . 'users/lists';
        
        $data['lists'] = $this->user->getAllUser($username, $uri_segment, $per_page);
        
        $config['base_url'] = $base_url;
        $config['total_rows'] = $this->user->table_record_count;
        $config['per_page'] = $per_page;
        $config['num_links'] = NUM_LINKS;
        $config['uri_segment'] = 4;
        $config['first_link'] = '&laquo; First';
        $config['last_link'] = 'Last &raquo;';
        $config['prev_link'] = '&laquo; Previous';
        $config['next_link'] = 'Next &raquo;';
        $config['anchor_class'] = 'class="number"';
        
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'users/lists', $data, TRUE);
        $temp['header'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_header', $header, TRUE);
        $temp['sidebar'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_sidebar', null, TRUE);
        $temp['content'] = $content;
        $temp['footer'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_footer', null, TRUE);
        $this->load->view(BACK_END_TMPL_PATH . 'template', $temp);
    }

    function edit($id = null)
    {
        $header['title'] = 'Thêm User';
        $task = 'add';
        
        $data = array();
        if ($id) {
            $header['title'] = 'Chỉnh sửa user';
            $data['user'] = $this->user->find_by_pkey($id);
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
            
            redirect(BACK_END_TMPL_PATH . 'users/lists');
        }
        
        $data['title'] = $header['title'];
        $data['task'] = $task;
        $data['subjects'] = $this->subject_model->getAllSubjects();
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'users/edit', $data, TRUE);
        $temp['header'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_header', $header, TRUE);
        $temp['sidebar'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_sidebar', null, TRUE);
        $temp['content'] = $content;
        $temp['footer'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_footer', null, TRUE);
        $this->load->view(BACK_END_TMPL_PATH . 'template', $temp);
    }
}
