<?php
class Storage extends Ext_Controller
{
    protected $mainModel = 'storage_model';
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('storage_model');
        $this->load->model('subject_model');
        $this->load->model('storage_question_model');
        $this->load->model('storage_answer_model');
        
        $this->load->library([
            'utils',
            'lib/storagelib',
            'form_validation'
        ]);
    }

    public function lists()
    {
        $header['title'] = 'Quản lý kho câu hỏi';
        
        // get data
        $per_page = 20;
        $data = array();
        
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        // get user Information
        $user = $this->getUserInfo();
        
        $data['lists'] = $this->storage_model->getStorageList($user->subjects_id, $per_page, $segment);
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'storage/lists', $data, TRUE);
        
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $titleHeader = 'Thêm kho chứa mới';
        $data = array();
        
        if ($this->input->post()) {
            $id = (int) $this->input->post('storage_id', 0);
            $title = $this->input->post('title');
            $isValid = $this->storagelib->validate($title);
            if($isValid) {
                $value['title'] = sanitizeText($title);
                $subjects_id = $this->getUserInfo()->subjects_id;
                if ($subjects_id) {
                    $value['subjects_id'] = $subjects_id;
                } else {
                    $value['subjects_id'] = (int) $this->input->post('subjects_id');
                }
                
                if (! $id) {
                    $this->storage_model->create($value);
                } else {
                    $this->storage_model->update_by_pkey($id, $value);
                }
                unset($value);
                redirect(BACKEND_V2_TMPL_PATH . 'storage/lists');
            }
        }
        
        if ($id) {
            $title = 'Chỉnh sửa kho chứa';
            $data['storage'] = $this->storage_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        $header['title'] = $titleHeader;
        $data['title'] = $titleHeader;
        $data['user'] = $this->getUserInfo();
        $data['subjects'] = $this->subject_model->getAll();
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'storage/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }
    
    // xuat excel
    public function export($id)
    {
        $storage_id = (int) $id;
        $this->storagelib->export($storage_id);
    }
    
    public function uploadfile()
    {
        $extension = pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION);
        $newFilename = uniqid() . '.' . $extension;
        $file = BACKEND_V2_TMP_PATH_ROOT . $newFilename;
        // Check file size
        if ($_FILES["file"]["size"] > 5000000) {
            $this->sendAjax(1, "Kích thước file không thể quá 5MB.");
        } elseif ($extension != "doc" && $extension != "docx") {
            $this->sendAjax(1, "Định dạng file không hợp lệ");
        } elseif (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
            $storage_id = $this->input->post('storage_id', 0);
            if ($storage_id) {
                $result = $this->storagelib->saveFileData($storage_id, $newFilename);
                $this->sendAjax($result['status'], $result['message'], $result['data']);
            }
        } else {
            $this->sendAjax(1, 'Không thể upload file');
        }
    }
}