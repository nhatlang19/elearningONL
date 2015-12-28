<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Clazz extends Ext_Controller
{
    protected $mainModel = 'class_model';
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('class_model');
        $this->load->model('block_model');
        
        $this->load->library([
            'lib/clazzlib',
        ]);
    }

    public function lists()
    {
        $header['title'] = 'Quản lý lớp học';
        
        // get data
        $per_page = 10;
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        $data = [];
        $data['lists'] = $this->class_model->getAll($segment, $per_page);
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'clazz/lists', $data, true);
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm lớp';
        
        $data = array();
        if ($this->input->post()) {
            $id = $this->input->post('id', 0);
            $data['class_name'] = strtoupper(sanitizeText($this->input->post('class_name')));
            $data['block_id'] = intval($this->input->post('block_id'));
            $isValid = $this->clazzlib->validate($data);
            if($isValid) {
                if (! $id) {
                    // save into academic table
                    $this->class_model->create($data);
                } else {
                    $this->class_model->update_by_pkey($id, $data);
                }
                unset($data);
                
                // remove cache after create/update 
                $this->lphcache->cleanCacheByFunction($this->class_model->table_name, 'getAll');
                
                redirect(BACKEND_V2_TMPL_PATH . 'clazz/lists');
            }
        }
        
        if ($id) {
            $header['title'] = 'Chỉnh sửa lớp';
            $data['clazz'] = $this->class_model->find_by_pkey($id);
        
            $data['id'] = $id;
        }
        
        $data['title'] = $header['title'];
        $data['blocks'] = $this->block_model->getAll();
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'clazz/edit', $data, true);
        $this->loadTemnplateBackend($header, $content);
    }
}
