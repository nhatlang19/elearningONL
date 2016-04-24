<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        if (! $this->session->userdata('studentInfo')) {
            redirect('dang-nhap');
        }
        
        $this->load->model('topic_model');
        $this->load->model('topic_manage_model');
        $this->load->model('block_model');
        $this->load->model('class_model');
        $this->load->model('student_info_model');
        $this->load->model('student_answer_model');
        $this->load->model('student_mark_model');
        $this->load->model('student_topic_model');
        $this->load->model('score_model');
        $this->load->library([
            'commonobj',
            'components/score',
            'components/word', 'utils'
        ]);
    }

    /**
     * result Action
     */
    public function result()
    {
        $student = $this->session->userdata('studentInfo');
        if (isset($student->finished) && $student->finished) {
            $student_id = $student->student_id;
            $student_mark_id = $student->student_mark_id;
            $topic = $this->session->userdata('topic_' . $student_id);
            $topic_id = $topic->topic_id;
            //$this->score->calScore($topic_id, $student_id, $student_mark_id);
            $review_show = $this->topic_manage_model->getReviewStatus($topic->topic_manage_id);
            // get score of student
            $data['score'] = $this->student_mark_model->getMarkStudentById($student_mark_id);
            $data['answers_student'] = $this->student_answer_model->getAnswerOfStudentId($student_id, $topic_id, $student_mark_id);
            $data['list'] = $this->utils->makeList('question_id', $data['answers_student']);
            $data['student'] = $student;
            $data['info_user'] = $this->_loadInfoUser($topic);
            if ($review_show['review'] == 'SHOW') {
                $data['topic_details'] = $this->topic_model->getData($topic_id);
            }
            
            $student->result = true;
            $session = array(
                'studentInfo' => $student
            );
            $this->session->set_userdata($session);
            // load template
            $content = $this->load->view(FRONT_END_TMPL_PATH . 'result', $data, TRUE);
            $header['title'] = EXAM_RESULT;
            $this->loadTemplate($header, $content);
        } else {
            show_404();
        }
    }
    
    public function student_finished() {
        $student = $this->session->userdata('studentInfo');
        $student_id = $student->student_id;
        
        $topic_manage = $this->topic_manage_model->getPublishedDistinct();
        $studentTopic = $this->student_topic_model->getTopicStudent($topic_manage->topic_manage_id, $student->student_id);
        $topic_id = $studentTopic->topic_id;
        
        if(empty($studentTopic) || !$studentTopic->finished) {
            show_404();
        }
        
        $review_show = $this->topic_manage_model->getReviewStatus($studentTopic->topic_manage_id);
        
        // get score of student
        $data['score'] = $this->student_mark_model->getMarkStudentById($studentTopic->student_mark_id);
        $data['answers_student'] = $this->student_answer_model->getAnswerOfStudentId($student_id, $topic_id, $studentTopic->student_mark_id);
        $data['list'] = $this->utils->makeList('question_id', $data['answers_student']);
        $data['student'] = $student;
        $data['info_user'] = $this->_loadInfoUser($studentTopic);
        if ($review_show['review'] == 'SHOW') {
            $data['topic_details'] = $this->topic_model->getData($topic_id);
        }
        
        // load template
        $content = $this->load->view(FRONT_END_TMPL_PATH . 'result', $data, TRUE);
        $header['title'] = EXAM_RESULT;
        $this->loadTemplate($header, $content);
    }

    /**
     * save Action
     */
    public function save()
    {
        $student_id = 0;
        if ($this->input->post()) {
            // get student Id
            $student = $this->session->userdata('studentInfo');
            $student_id = $student->student_id;
            $topic = $this->session->userdata('topic_' . $student_id);
            $topic_id = $topic->topic_id;
            if ($student_id) {
                $student_mark_id = $this->student_mark_model->createNew($student_id, $topic_id);
                /**
                 * luu cau tra loi cua student *
                 */
                // nhan thong tin cau tra loi cua student
                $posts = $this->input->post();
                // tao mang gia tri cua tra loi cua student
                $student_answer = array();
                $number = 0;
                // $code = $posts['topic_id'];
                
                $answerData = isset($posts['data']) ? $posts['data'] : array();
                if(!empty($answerData)) {
                    if(isset($answerData['any'])) {
                        foreach ($answerData['any'] as $question_id => $answer) {
                            list ($qid, $number_question) = explode('_', $question_id);
                            $array = array();
                            $array['student_id'] = $student_id;
                            $array['question_id'] = $qid;
                            $array['topic_id'] = $topic_id;
                            $array['answer'] = $answer + 1;
                            $array['number_question'] = $number_question;
                            $array['student_mark_id'] = $student_mark_id;
                            // them vao mang
                            $student_answer[] = $array;
                        }
                    }
                    if(isset($answerData['many'])) {
                        foreach ($answerData['many'] as $question_id => $answers) {
							foreach($answers as $key => $answer) {
								$answers[$key] = $answer + 1;
							}
                            list ($qid, $number_question) = explode('_', $question_id);
                            $array = array();
                            $array['student_id'] = $student_id;
                            $array['question_id'] = $qid;
                            $array['topic_id'] = $topic_id;
                            $array['answer'] = implode(SEPARATE_CORRECT_ANSWER, $answers);
                            $array['number_question'] = $number_question;
                            $array['student_mark_id'] = $student_mark_id;
                            // them vao mang
                            $student_answer[] = $array;
                        }
                    }
                }
                $this->student_topic_model->updateFinished($student_id, $topic_id, $student_mark_id);
                if (count($student_answer)) {
                    // xoa du lieu trung
                    $this->student_answer_model->deleteAnswerOfStudent($student_id, $topic_id);
                    // them du lieu vao bang student_answer
                    $this->student_answer_model->create_batch($student_answer);
                }
                
                // calculate mark for student
                $this->score->calScore($topic_id, $student_id, $student_mark_id);
                
                // save file dap an cua hos sinh
                $this->word->exportResultStudent($student, $topic, $student_mark_id);
                
                $student->finished = TRUE;
                $student->student_mark_id = $student_mark_id;
                $session = array(
                    'studentInfo' => $student
                );
                $this->session->set_userdata($session);
            }
            
            redirect('exam/result');
        } else {
            show_404();
        }
    }
    
    public function quote()
    {
        $student = $this->session->userdata('studentInfo');
        
        $header['title'] = EXAM_QUOTE;
        if (! isset($student->result)) {
            $topic_manage = $this->topic_manage_model->getPublishedDistinct();
            if (empty($topic_manage)) {
                $page['noTopic'] = NO_TOPIC;
                $content = $this->load->view(FRONT_END_TMPL_PATH . 'no_topic', $page, TRUE);
            } else {
                $studentTopic = $this->student_topic_model->getTopicStudent($topic_manage->topic_manage_id, $student->student_id);
                if(!empty($studentTopic)) {
                    if($studentTopic->finished) {
                        redirect('exam/student_finished');
                    }
                    $topic = $studentTopic;
                } else {
                    $topic = $this->topic_model->getTopicByTopicManageIdRandom($topic_manage->topic_manage_id);
                    
                    $this->student_topic_model->createData($student->student_id, $topic->topic_id);
                }
                // update session
                $student->topic_id = $topic->topic_id;
                $session = array(
                    'studentInfo' => $student,
                    'topic_' . $student->student_id => $topic
                );
                $this->session->set_userdata($session);
                $data = $this->topic_model->getDataNoCorrectAnswer($topic->topic_id);
                // gen JSON data
                $questions = array();
                foreach ($data as $key => $question) {
                    $tmp = array();
                    $tmp['q'] = $this->utils->changeLocalhostToServerIP(stripslashes($question->question_name));
                    $tmp['storageQuestionId'] = $question->storage_question_id;
                    $arrayAnswer = explode('|||', $question->answer);
                    $tmp['number'] = $question->number;
                    $tmp['select_any'] = $question->select_any ? true : false;
                    $tmp['correct'] = '';
                    $tmp['incorrect'] = '';
                    foreach ($arrayAnswer as $answer) {
                        $tmp['a'][] = array(
                            'option' => $this->utils->changeLocalhostToServerIP(stripslashes($answer)),
                            'correct' => false
                        );
                    }
                    
                    $questions[] = $tmp;
                }
                $page['minute'] = $topic_manage->time;
                $page['info_user'] = $this->_loadInfoUser($topic);
                $page['jsonData'] = json_encode($questions);
                $page['code'] = $topic->code;
                $content = $this->load->view(FRONT_END_TMPL_PATH . 'topics', $page, TRUE);
            }
            $this->loadTemplate($header, $content);
        } else {
            show_404();
        }
    }

    function _loadInfoUser($topic)
    {
        $data['code'] = $topic->code;
        return $this->load->view(FRONT_END_TMPL_PATH . 'info_user', $data, TRUE);
    }

    function _loadTime($time)
    {
        $data['minute'] = $time;
        return $this->load->view(FRONT_END_TMPL_PATH . 'time', $data, TRUE);
    }

    /**
     * load template file
     * $header : array header data
     * $content : content data
     */
    function loadTemplate($header = "", $content = "")
    {
        
        // load header template
        $template['header'] = $this->load->view(COMMON_TMPL_PATH . 'header', $header, true);
        
        $template['content'] = $content;
        
        // load footer template
        $template['footer'] = $this->load->view(COMMON_TMPL_PATH . 'footer', '', true);
        
        $this->load->view(COMMON_TMPL_PATH . 'template', $template);
    }
    
    protected function sendAjax($status = 0, $message = '', $data = [])
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}

/* End of file exam.php */
/* Location: ./application/controllers/exam.php */