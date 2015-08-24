<?php

class Storage extends Ext_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('storage_model');
        $this->load->model('subject_model');
        $this->load->model('storage_question_model');
        $this->load->model('storage_answer_model');
    }

    public function lists()
    {
        $header['title'] = 'Quản lý kho câu hỏi';
        
        // get data
        $per_page = 20;
        $title = $this->input->post('title', null);
        $data = array();
        
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        // get user Information
        $user = $this->getUserInfo();
        
        $data['lists'] = $this->storage_model->getStorageList($title, $user->subjects_id, $per_page, $segment);
        
        $base_url = base_url() . BACKEND_V2_TMPL_PATH . 'storage/lists';
        $config = $this->configPagination($base_url, $this->storage_model->table_record_count, $per_page, self::URI_SEGMENT);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'storage/lists', $data, TRUE);
        
        $this->loadTemnplateBackend($header, $content);
    }

    public function edit($id = null)
    {
        $title = 'Thêm kho chứa mới';
        $data = array();
        if ($id) {
            $title = 'Chỉnh sửa kho chứa';
            $data['storage'] = $this->storage_model->find_by_pkey($id);
            $data['id'] = $id;
        }
        if ($this->input->post()) {
            
            $id = (int) $this->input->post('storage_id', 0);
            $value['title'] = addslashes($this->input->post('title'));
            
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
        
        $header['title'] = $title;
        $data['title'] = $title;
        $data['user'] = $this->getUserInfo();
        $data['subjects'] = $this->subject_model->getAll();
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'storage/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    public function delete($id = null)
    {
        if ($this->input->is_ajax_request() && $id) {
            $id = intval($id);
            $this->storage_model->delete_by_pkey($id);
            $this->sendAjax();
        } else {
            show_404();
        }
    }
    
    // xuat excel
    public function export($id)
    {
        $storage_id = (int) $id;
        
        $this->load->library([
            'components/word',
            'utils'
        ]);
        
        // contents
        $storages = $this->storage_model->exportData($storage_id);
        $storage = $this->storage_model->find_by_pkey($storage_id);
        $filename = $this->utils->format_title_export_docx($storage['title']);
        
        $this->word->exportStorages($filename, $storages);
    }

    public function _saveFileData($storage_id, $fileName)
    {
        $uploadpath = 'public/backendV2/tmp/' . $fileName;
        $this->load->library([
            'components/word',
        ]);
        $storage_id = (int) $storage_id;
        
        $rows = $this->word->importFromDocx($uploadpath);
        if (! empty($rows)) {
            $batchDataQuestions = [];
            $batchDataAnswers = [];
            $listHashQuestions = [];
            for ($i = 0, $n = count($rows); $i < $n; $i += 6) {
                $cell = $rows[$i][1];
                
                $data = [];
                $data['question_name'] = trim($rows[$i][1]);
                $data['storage_id'] = $storage_id;
                $hash = md5($data['storage_id'] . '_' . $data['question_name']);
                $data['hashkey'] = $hash;
                $batchDataQuestions[] = $data;
                
                $listHashQuestions[] = $hash;
                // answers
                $cell_right_answer = explode(',', trim(strip_tags($rows[$i + 5][1])));
                for ($k = $i + 1; $k < $i + 5; $k ++) {
                    $data = [];
                    $char = trim(strip_tags($rows[$k][0]));
                    if (in_array($char, $cell_right_answer)) {
                        $data['correct_answer'] = 1;
                    } else {
                        $data['correct_answer'] = 0;
                    }
                    
                    $data['answer'] = trim($rows[$k][1]);
                    $data['hashkey'] = $hash;
                    $batchDataAnswers[] = $data;
                }
            }
            
            // import csv into storage questions
            $questionsCsvName = BACKEND_V2_TMP_PATH_ROOT . uniqid() . '.csv';
            $this->exportToCsvTemp($questionsCsvName, $batchDataQuestions);
            $this->storage_question_model->loadDataInfile($questionsCsvName);
            
            // truncate answer by hash key
            $this->storage_answer_model->deleteByHash($listHashQuestions);
            
            // import csv into storage answers
            $answerCsvName = BACKEND_V2_TMP_PATH_ROOT . uniqid() . '.csv';
            $this->exportToCsvTemp($answerCsvName, $batchDataAnswers);
            $this->storage_answer_model->loadDataInfile($answerCsvName);
            
            $storageQuestions = $this->storage_question_model->getCountByStorageId($storage_id);
            $this->sendAjax(0, '', ['numberOfQuestions' => $storageQuestions]);
        } else {
            $this->sendAjax(1, 'Cấu trúc file không hợp lệ');
        }
        
        @unlink($uploadpath);
    }
    
    public function uploadfile()
    {
        $file = BACKEND_V2_TMP_PATH_ROOT . basename($_FILES['file']['name']);
        $imageFileType = pathinfo($file, PATHINFO_EXTENSION);
        // Check file size
        if ($_FILES["file"]["size"] > 5000000) {
            $this->sendAjax(1, "Kích thước file không thể quá 5MB.");
        } elseif ($imageFileType != "doc" && $imageFileType != "docx") {
            $this->sendAjax(1, "Định dạng file không hợp lệ");
        } elseif (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
            $storage_id = $this->input->post('storage_id', 0);
            if ($storage_id) {
                $this->_saveFileData($storage_id, $_FILES['file']['name']);
            }
        } else {
            $this->sendAjax(1, 'Không thể upload file');
        }
    }
}