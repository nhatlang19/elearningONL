<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Subject extends Ext_Controller
{
    protected $mainModel = 'subject_model';

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('subject_model');
        
        $this->load->library([
            'lib/SubjectlIb',
        ]);
    }

    public function lists()
    {
        $header['title'] = 'Quản lý môn học';
        
        // get data
        $per_page = 10;
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        $data = [];
        $data['lists'] = $this->subject_model->getAll($segment, $per_page);
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'subject/lists', $data, true);
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $header['title'] = 'Thêm môn học';
        
        $data = array();
        
        if ($this->input->post()) {
            $id = $this->input->post('id', 0);
            $data['subjects_name'] = sanitizeText($this->input->post('subjects_name'));
            $isValid = $this->subjectlib->validate($data);
            if($isValid) {
                if (! $id) {
                    // save into subject table
                    $this->subject_model->create($data);
                } else {
                    $this->subject_model->update_by_pkey($id, $data);
                }
                unset($data);
                
                // remove cache after create/update
                $this->lphcache->cleanCacheByFunction($this->subject_model->table_name, 'getAll');
                
                redirect(BACKEND_V2_TMPL_PATH . 'subject/lists');
            }
        }
        
        if ($id) {
            $header['title'] = 'Chỉnh sửa môn học';
            $data['subject'] = $this->subject_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        
        $data['title'] = $header['title'];
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'subject/edit', $data, true);
        $this->loadTemnplateBackend($header, $content);
    }
    
}
