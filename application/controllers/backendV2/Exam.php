<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam extends Ext_Controller
{
    protected $mainModel = 'exam_model';
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('exam_model');
        
        $this->load->library([
            'lib/Examlib',
        ]);
    }

    public function lists()
    {
        $header['title'] = 'Quản lý hình thức thi';
        
        $per_page = 10;
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        $data = [];
        $data['lists'] = $this->exam_model->getAll($segment, $per_page);
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'exam/lists', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm hình thức thi';
        
        $data = array();
        
        if ($this->input->post()) {
            $id = intval($this->input->post('id'));
            
            $data['title'] = sanitizeText($this->input->post('title'));
            $data['time'] = intval($this->input->post('time'));
            $isValid = $this->examlib->validate($data);
            if($isValid) {
                if (! $id) {
                    // save into exam table
                    $this->exam_model->create_ignore($data);
                } else {
                    $this->exam_model->update_by_pkey($id, $data);
                }
                
                unset($data);
                
                // remove cache after create/update
                $this->lphcache->cleanCacheByFunction($this->exam_model->table_name, 'getAll');
                
                redirect(BACKEND_V2_TMPL_PATH . 'exam/lists');
            }
        }
        
        if ($id) {
            $header['title'] = 'Chỉnh sửa hình thức thi';
            $data['exam'] = $this->exam_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        
        $data['title'] = $header['title'];
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'exam/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    public function published()
    {}

    public function unpublished()
    {}
}
