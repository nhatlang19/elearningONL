<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Academic extends Ext_Controller
{
    protected $mainModel = 'academic_model';
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('academic_model');
        
        $this->load->library([
            'lib/academiclib',
        ]);
    }

    public function lists()
    {
        $header['title'] = 'Quản lý niên khóa';
        
         // get data
        $per_page = 10;
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        $data = [];
        $data['lists'] = $this->academic_model->getAll($segment, $per_page);
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'academic/lists', $data, true);
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm niên khóa mới';
        
        $data = array();
        
        if ($this->input->post()) {
            $id = $this->input->post('id', 0);
            $data['academic_name'] = sanitizeText($this->input->post('academic_name'));
            
            $isValid = $this->academiclib->validate($data);
            if($isValid) {
                if (! $id) {
                    // save into academic table
                    $this->academic_model->create($data);
                } else {
                    $this->academic_model->update_by_pkey($id, $data);
                }
                unset($data);
                
                // remove cache after create/update
                $this->lphcache->cleanCacheByFunction($this->academic_model->table_name, 'getAll');
                
                redirect(BACKEND_V2_TMPL_PATH . 'academic/lists');
            }
        }
        if ($id) {
            $header['title'] = 'Chỉnh sửa niên khóa';
            $data['academic'] = $this->academic_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        
        $data['title'] = $header['title'];
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'academic/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }
}

/* End of file academic.php */
/* Location: ./application/controllers/academic.php */