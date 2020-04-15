<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Block extends Ext_Controller
{
    protected $mainModel = 'block_model';
    
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('block_model');
        
        $this->load->library([
            'lib/Blocklib',
        ]);
    }

    public function lists()
    {
        $header['title'] = 'Quản lý khối học';
        
        $per_page = 10;
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        $data = [];
        $data['lists'] = $this->block_model->getAll($segment, $per_page);
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'block/lists', $data, true);
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm khối';
        
        $data = array();
        if ($this->input->post()) {
            $id = $this->input->post('id', 0);
            $data['title'] = sanitizeText($this->input->post('title'));
            $isValid = $this->blocklib->validate($data);
            if($isValid) {
                if (! $id) {
                    // save into academic table
                    $this->block_model->create($data);
                } else {
                    $this->block_model->update_by_pkey($id, $data);
                }
                unset($data);
                
                // remove cache after create/update 
                $this->lphcache->cleanCacheByFunction($this->block_model->table_name, 'getAll');
                
                redirect(BACKEND_V2_TMPL_PATH . 'block/lists');
            }
        }
        
        if ($id) {
            $header['title'] = 'Chỉnh sửa khối';
            $data['block'] = $this->block_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        
        $data['title'] = $header['title'];
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'block/edit', $data, true);
        $this->loadTemnplateBackend($header, $content);
    }
}
