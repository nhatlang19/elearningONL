<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * class khối
 * 
 * @author nhox
 *        
 */
class Block extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('block_model');
    }

    function lists()
    {
        $header['title'] = 'Quản lý khối học';
        
        // get data
        $per_page = 10;
        $title = $this->input->post('title');
        $data = array();
        
        $segment = $this->uri->segment(self::_URI_SEGMENT);
        
        $base_url = base_url() . BACK_END_TMPL_PATH . 'block/lists';
        
        $data['lists'] = $this->block_model->getAllBlock($title, $segment, $per_page);
        
        $config = $this->configPagination($base_url, $this->block_model->table_record_count, $per_page, self::_URI_SEGMENT);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACK_END_TMPL_PATH . 'block/lists', $data, TRUE);
        $this->_loadTemnplateAdmin($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm khối';
        $task = 'add';
        
        $data = array();
        if ($id) {
            $header['title'] = 'Chỉnh sửa khối';
            $data['block'] = $this->block_model->find_by_pkey($id);
            $data['id'] = $id;
            $task = 'edit';
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $data['title'] = $this->input->post('title');
            
            if (! $id) {
                // save into academic table
                $this->block_model->create($data);
            } else {
                $this->block_model->update_by_pkey($id, $data);
            }
            unset($data);
            
            redirect(BACK_END_TMPL_PATH . 'block/lists');
        }
        
        $data['title'] = $header['title'];
        $data['task'] = $task;
        $content = $this->load->view(BACK_END_TMPL_PATH . 'block/edit', $data, TRUE);
        $this->_loadTemnplateAdmin($header, $content);
    }
}

/* End of file storage.php */
/* Location: ./application/controllers/storage.php */