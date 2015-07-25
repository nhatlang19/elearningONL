<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * class lớp
 * 
 * @author nhox
 *        
 */
class Lop extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('class_model');
        $this->load->model('block_model');
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function lists()
    {
        $header['title'] = 'Quản lý lớp học';
        
        // get data
        $per_page = 10;
        $title = $this->input->post('class_name');
        $data = array();
        
        $segment = $this->uri->segment(self::_URI_SEGMENT);
        
        $base_url = base_url() . BACK_END_TMPL_PATH . 'lop/lists';
        
        $data['lists'] = $this->class_model->getAllClass($title, $segment, $per_page);
        
        $config = $this->configPagination($base_url, $this->class_model->table_record_count, $per_page, self::_URI_SEGMENT);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'lop/lists', $data, TRUE);
        $this->loadTemnplateAdmin($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm lớp';
        $task = 'add';
        
        $data = array();
        if ($id) {
            $header['title'] = 'Chỉnh sửa lớp';
            $data['class'] = $this->class_model->find_by_pkey($id);
            
            $data['id'] = $id;
            $task = 'edit';
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data['class_name'] = $this->input->post('class_name');
            $data['block_id'] = intval($this->input->post('block_id'));
            
            if (! $id) {
                // save into academic table
                $this->class_model->create($data);
            } else {
                $this->class_model->update_by_pkey($id, $data);
            }
            unset($data);
            
            redirect(BACK_END_TMPL_PATH . 'lop/lists');
        }
        
        $data['title'] = $header['title'];
        $data['task'] = $task;
        $data['blocks'] = $this->block_model->getAllBlock();
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'lop/edit', $data, TRUE);
        $this->loadTemnplateAdmin($header, $content);
    }

    public function published()
    {}

    public function unpublished()
    {}
}

/* End of file storage.php */
/* Location: ./application/controllers/storage.php */