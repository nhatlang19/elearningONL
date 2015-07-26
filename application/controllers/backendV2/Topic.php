<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Topic extends Ext_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->load->model('storage_model');
        $this->load->model('storage_question_model');
        $this->load->model('storage_answer_model');
        $this->load->model('academic_model');
        $this->load->model('exam_model');
        $this->load->model('topic_model');
        $this->load->model('topic_manage_model');
        $this->load->model('topic_file_model');
        $this->load->model('question_model');
        $this->load->model('answer_model');
        $this->load->model('student_mark_model');
    }

    public function lists()
    {
        // initialize
        $per_page = PER_PAGE;
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        $header['title'] = 'Quản lý đề thi';
        $data = array();
        
        // filter
        $storage_id = $this->input->post('storage_id'); // kho nao
        $academic_id = $this->input->post('academic_id'); // nien khoa
        $exam_id = $this->input->post('exam_id'); // loai hinh thi
        
        $data['topics'] = $this->topic_manage_model->getTopicList($academic_id, $exam_id, $this->getUserInfo()->subjects_id, $per_page, $segment);
        
        $base_url = base_url() . BACKEND_V2_TMPL_PATH . 'topic/lists';
        $config = $this->configPagination($base_url, $this->storage_model->table_record_count, $per_page, self::URI_SEGMENT);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'topic/lists', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    /**
     * View list in trash
     */
    public function list_trash()
    {
        // initialize
        $per_page = PER_PAGE;
        $segment = $this->uri->segment(self::URI_SEGMENT);
        
        $header['title'] = 'Quản lý đề thi';
        $data = array();
        
        // filter
        $storage_id = $this->input->post('storage_id'); // kho nao
        $academic_id = $this->input->post('academic_id'); // nien khoa
        $exam_id = $this->input->post('exam_id'); // loai hinh thi
        
        $data['topics'] = $this->topic_manage_model->getTopicListTrash($academic_id, $exam_id, $this->getUserInfo()->subjects_id, $per_page, $segment);
        
        $base_url = base_url() . BACKEND_V2_TMPL_PATH . 'topic/lists';
        $config = $this->configPagination($base_url, $this->storage_model->table_record_count, $per_page, self::URI_SEGMENT);
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination;
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'topic/list_trash', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    function published($topic_manage_id)
    {
        $topic_manage_id = intval($topic_manage_id);
        $this->topic_manage_model->published($topic_manage_id);
        
        redirect(BACKEND_V2_TMPL_PATH . 'topic/lists');
    }

    function delete($topic_manage_id)
    {
        $topic_manage_id = intval($topic_manage_id);
        $result = $this->topic_manage_model->getByIdNoJoin($topic_manage_id);
        if (! $result['published']) {
            $result = $this->topic_manage_model->delete($topic_manage_id);
        } else {
            $result = false;
            $array['message'] = 'Chủ đề này đang được kích hoạt. Không thể xoá bây giờ';
        }
        
        $array['result'] = $result;
        echo json_encode($array);
    }

    function restore($topic_manage_id)
    {
        $topic_manage_id = intval($topic_manage_id);
        
        $result = $this->topic_manage_model->restore($topic_manage_id);
        $array['result'] = $result;
        echo json_encode($array);
    }

    function export($id)
    {
        $tid = intval(substr($id, strpos($id, 'tid') + 3, strlen($id)));
        
        $topic_manage = $this->topic_manage_model->findById($tid);
        $topic_manage['created_time'] = setDate($topic_manage['created_time'], 'notime');
        
        // create folder name
        ob_start();
        $this->load->library('stringobj');
        $title = $this->stringobj->createAlias(implode('_', $topic_manage), '_');
        if (! file_exists(BACKEND_V2_DOC_PATH_DIR . $title)) {
            mkdir(BACKEND_V2_DOC_PATH_DIR . $title);
        }
        
        // danh sach đề thi
        $topics = $this->topic_model->getTopicByTopicManageId($tid);
        
        // gen msdoc
        $this->load->library('msdocgenerator');
        $array_topic = array();
        $results = array();
        foreach ($topics as $key => $topic) {
            
            // đề thứ i
            $title_topic = 'De ' . $topic['code'] . ".doc";
            
            $data = $this->topic_model->getData($topic['topic_id']);
            $results[$key]['code'] = $topic['code'];
            $results[$key]['data'] = $data;
            foreach ($data as $item) {
                $this->msdocgenerator->addParagraph('<b>Câu ' . $item['number'] . ':</b> ' . strip_slashes(nl2br($item['question_name'])));
                
                $answers = explode('|||', $item['answer']);
                $num = 65;
                foreach ($answers as $answer) {
                    $this->msdocgenerator->addParagraph(chr($num) . '. ' . strip_slashes(nl2br($answer)));
                    $num ++;
                }
            }
            $this->msdocgenerator->setDocumentCharset('UTF-8');
            $this->msdocgenerator->output($title_topic, BACKEND_V2_DOC_PATH_DIR . $title);
            $array_topic[] = BACKEND_V2_DOC_PATH_DIR . $title . '/' . $title_topic;
            
            // ghi file dap an
            $title_topic = 'De ' . $topic['code'] . " - dap an.doc";
            $this->msdocgenerator->addParagraph('<b>Đáp án:</b>');
            $this->msdocgenerator->startTable();
            $cells = array();
            foreach ($data as $item) {
                $answers = explode(',', $item['correct_answer']);
                $num = 65;
                foreach ($answers as $i => $answer) {
                    if ($answer) {
                        $cells[] = $item['number'] . chr($num);
                        break;
                    }
                    $num ++;
                }
                
                if (count($cells) == 4) {
                    $this->msdocgenerator->addTableRow($cells);
                    unset($cells);
                }
            }
            if (isset($cells) && count($cells) <= 4) {
                $this->msdocgenerator->addTableRow($cells);
            }
            $this->msdocgenerator->endTable();
            $this->msdocgenerator->setDocumentCharset('UTF-8');
            $this->msdocgenerator->output($title_topic, BACKEND_V2_DOC_PATH_DIR . $title);
            $array_topic[] = BACKEND_V2_DOC_PATH_DIR . $title . '/' . $title_topic;
        }
        
        // zip folder
        $this->load->library('recursezip');
        $src = BACKEND_V2_DOC_PATH_DIR . $title;
        // Destination folder where we create Zip file.
        $dst = BACKEND_V2_DOC_PATH_DIR;
        $zip = $this->recursezip->compress($src, $dst);
        
        // delete doc file
        foreach ($array_topic as $topic) {
            @unlink($topic);
        }
        // delete folder
        @rmdir($src);
        
        // Download zip file.
        my_force_download($title . '.zip', $zip);
        flush();
        
        // delete zip file
        @unlink($zip);
    }

    function create()
    {
        $subjects_id = $this->getUserInfo()->subjects_id;
        
        if ($post = $this->input->post()) {
            
            // request
            $number_question = (int) $this->input->post('number_question'); // so cau hoi
            $number_topic = (int) $this->input->post('number_topic'); // so de thi
            $storage_id = (int) $this->input->post('storage_id'); // kho nao
            $academic_id = (int) $this->input->post('academic_id'); // nien khoa
            $exam_id = (int) $this->input->post('exam_id'); // loai hinh thi
            $title = strip_tags($this->input->post('title')); // tiều đề đề thi
                                                                    
            // list storage_question_id
            $list = $this->storage_question_model->getStorageQuestionByStorageIdRandom($storage_id, $number_question);
            
            $sqid_list = explode('|||', $list['sqid']);
            
            // lay danh sach cau tra loi tuong ung voi cau hoi
            $answer_list = $this->storage_answer_model->getAnswerBySqid($sqid_list);
            
            $array_data = array();
            // duyet danh sach cau hoi
            foreach ($sqid_list as $key => $sqid) {
                $array_data[$key]['storage_question_id'] = $sqid;
                // duyet danh sach cau tra loi
                foreach ($answer_list as $k => $answer) {
                    if ($answer['storage_question_id'] == $sqid) {
                        $array_data[$key]['answers'][] = $answer['storage_answer_id'] . ':' . $answer['correct_answer'];
                        unset($answer_list[$k]);
                    }
                }
            }
            
            // insert into topic_manage
            $topic_data['exam_id'] = $exam_id;
            $topic_data['academic_id'] = $academic_id;
            $topic_data['created_time'] = date('Y-m-d');
            $topic_data['title'] = $title;
            $topic_data['number_questions'] = $number_question;
            $topic_data['subjects_id'] = $subjects_id;
            $topic_manage_id = $this->topic_manage_model->create($topic_data);
            unset($topic_data);
            
            $question = array();
            $answers = array();
            $aindex = 0;
            $qindex = 0;
            
            for ($i = 0; $i < $number_topic; $i ++) {
                // insert topic
                $topic_data['code'] = $i + 1;
                $topic_data['topic_manage_id'] = $topic_manage_id;
                $topic_newid = $this->topic_model->create($topic_data);
                unset($topic_data);
                
                // random question sentences
                shuffle($array_data);
                $number = 1;
                foreach ($array_data as $key => $item) {
                    $question[$qindex]['storage_question_id'] = $item['storage_question_id'];
                    $question[$qindex]['topic_id'] = $topic_newid;
                    $question[$qindex]['number'] = $number ++;
                    ++ $qindex;
                    
                    // random answer sentences
                    shuffle($item['answers']);
                    
                    $num = 1;
                    foreach ($item['answers'] as $e) {
                        $element = explode(':', $e);
                        $answers[$aindex]['storage_answer_id'] = $element[0];
                        $answers[$aindex]['correct_answer'] = $element[1];
                        $answers[$aindex]['storage_question_id'] = $item['storage_question_id'];
                        $answers[$aindex]['topic_id'] = $topic_newid;
                        $answers[$aindex]['number'] = $num ++;
                        ++ $aindex;
                    }
                }
            }
            
            // save question & answer ( batch )
            // http://codeigniter.com/user_guide/database/active_record.html#insert
            $this->question_model->create_batch($question);
            $this->answer_model->create_batch($answers);
            
            unset($question);
            unset($answers);
            
            redirect(BACKEND_V2_TMPL_PATH . 'topic/lists');
        }
        
        $header['title'] = 'Tạo đề thi';
        $data['title'] = $header['title'];
        // load danh sach kho
        $data['list_storage'] = $this->storage_model->getStorageList(NULL, $subjects_id);
        
        // load nien khoa
        $data['list_academic'] = $this->academic_model->getAllAcademic();
        
        // load loai hinh thi
        $data['list_exam'] = $this->exam_model->getAllExam();
        
        $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'topic/edit', $data, TRUE);
        $this->loadTemnplateBackend($header, $content);
    }

    function change_review()
    {
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $data = $this->input->post();
            $topic_manage_id = intval($data['topic_manage_id']);
            $change_to = $data['change_to'];
            
            $result = $this->topic_manage_model->change_review($topic_manage_id, $change_to);
            if ($result) {
                $result = array();
                $result['reviewText'] = $change_to == 'show' ? 'Hiện' : 'Ẩn';
                $result['changeTo'] = ($change_to == 'show') ? 'hide' : 'show';
                $result['status'] = 1;
            } else {
                $array['status'] = 0;
            }
            
            echo json_encode($result);
        } else {
            exit('No direct script access allowed');
        }
    }

    function get_list_for_download()
    {
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $data = $this->input->post();
            $topic_manage_id = intval($data['topic_manage_id']);
            
            $data = array();
            $data['lists'] = $this->topic_file_model->getFilesTopicManageId($topic_manage_id);
            $content = $this->load->view(BACKEND_V2_TMPL_PATH . 'topic/list_download', $data, TRUE);
            
            $this->sendAjax(0, $content);
        } else {
            exit('No direct script access allowed');
        }
    }

    function download_student_answer($folder = null)
    {
        if ($folder) {
            $this->load->library('recursezip');
            $src = PATH_FILES_NO_ROOT . $folder;
            // Destination folder where we create Zip file.
            $dst = PATH_FILES_NO_ROOT;
            $zip = $this->recursezip->compress($src, $dst);
            
            // Download zip file.
            my_force_download($folder . '.zip', $zip);
            
            @unlink($zip);
        } else {
            exit('No direct script access allowed');
        }
    }

    function download_student_result($class_id = null)
    {
        $class_id = (int) $class_id;
        if ($class_id) {
            $this->load->library('Components/ExcelComponent');
            $this->excelcomponent->downloadStudentResult($class_id, false);
        } else {
            exit('No direct script access allowed');
        }
    }
}

/* End of file topic.php */
/* Location: ./application/controllers/topic.php */