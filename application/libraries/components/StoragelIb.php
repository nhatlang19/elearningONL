<?php
use App\Libraries\AppComponent;

require_once APPPATH . 'libraries/components/AppComponent.php';
include_once APPPATH . 'helpers/Traits/ExportCsvTrait.php';

class Storagelib extends AppComponent {
    use ExportCsvTrait;
    
    function __construct()
    {
        parent::__construct();
        
        $this->CI->load->model('storage_model');
        $this->CI->load->model('storage_question_model');
        $this->CI->load->model('storage_answer_model');
        
        $this->CI->load->library([
            'components/word',
            'utils',
            'form_validation'
        ]);
    }
    
    public function validate($title) {
        $oldTitle = $title;
        $title = sanitizeText($title);
        
        $this->CI->form_validation->set_data(array('title' => $title));
        $config = array(
            array(
                'field' => 'title',
                'label' => 'Tên kho',
                'rules' => 'required|min_length[6]|max_length[255]'
            )
        );
        $this->CI->form_validation->set_message('required', 'Tên kho [' . htmlentities($oldTitle) . ']  không hợp lệ');
        $this->CI->form_validation->set_message('min_length', 'Tên kho ít nhất phải có {param} ký tự');
        $this->CI->form_validation->set_message('max_length', 'Tên kho phải nhỏ hơn {param} ký tự');
        
        $this->CI->form_validation->set_rules($config);
        
        return $this->CI->form_validation->run();
    }
    
    public function export($storage_id) {
        $storage_id = (int) $storage_id;
        
        // contents
        $storages = $this->CI->storage_model->exportData($storage_id);
        $storage = $this->CI->storage_model->find_by_pkey($storage_id);
        $filename = $this->CI->utils->formatTitleExprortDocx($storage->title);
        $this->CI->word->exportStorages($filename, $storages);
    }
    
    public function saveFileData($storage_id, $fileName)
    {
        $uploadpath = BACKEND_V2_TMP_PATH_ROOT . $fileName;
        $storage_id = (int) $storage_id;
        $rows = $this->CI->word->importFromDocx($uploadpath);
        
        @unlink($uploadpath);
        if (! empty($rows)) {
            $batchDataQuestions = [];
            $batchDataAnswers = [];
            $listHashQuestions = [];
            for ($i = 0, $n = count($rows); $i < $n; $i += 6) {
                $cell = $rows[$i][1];
    
                $data = [];
                $data['question_name'] = $this->CI->utils->smart_clean($rows[$i][1]);
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
    
                    $data['answer'] = $this->CI->utils->smart_clean($rows[$k][1]);
                    $data['hashkey'] = $hash;
                    $batchDataAnswers[] = $data;
                }
            }
            // import csv into storage questions
            $questionsCsvName = BACKEND_V2_TMP_PATH_ROOT . uniqid() . '.csv';
            $this->exportToCsvTemp($questionsCsvName, $batchDataQuestions);
            $this->CI->storage_question_model->loadDataInfile($questionsCsvName);
    
            // truncate answer by hash key
            $this->CI->storage_answer_model->deleteByHash($listHashQuestions);
    
            // import csv into storage answers
            $answerCsvName = BACKEND_V2_TMP_PATH_ROOT . uniqid() . '.csv';
            $this->exportToCsvTemp($answerCsvName, $batchDataAnswers);
            $this->CI->storage_answer_model->loadDataInfile($answerCsvName);
    
            $storageQuestions = $this->CI->storage_question_model->getCountByStorageId($storage_id);
    
            // auto update storage_question_id
            // TODO: should be moved to background
            $this->autoUpdateStorageId($listHashQuestions);
            
            return ['status' => 0, 'message' => '', 'data' => ['numberOfQuestions' => $storageQuestions]];
        } else {
            return ['status' => 1, 'message' => 'Cấu trúc file không hợp lệ', 'data' => null];
        }
    
    }
    
    private function autoUpdateStorageId($listHashQuestions) {
        $storageQuestions = $this->CI->storage_question_model->getAllByHashkey($listHashQuestions);
        foreach($storageQuestions as $question) {
            $hashKey = $question->hashkey;
            $storage_question_id = $question->storage_question_id;
            $this->CI->storage_answer_model->updateStorageQuestionId($hashKey, $storage_question_id);
        }
    }
}