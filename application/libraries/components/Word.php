<?php

use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
use App\Libraries\AppComponent;
//error_reporting(E_ALL);
require_once __DIR__ . '/../PhpOffice/PhpWord/Autoloader.php';
require_once APPPATH . 'libraries/components/AppComponent.php';
/**
 * refs: https://github.com/PHPOffice/PHPWord/blob/master/samples/
 */
class Word extends AppComponent
{

    function __construct()
    {
        parent::__construct();
        
        Autoloader::register();
        Settings::loadConfig();
        
        Settings::setTempDir(getcwd() . TMPDIR_WORD);
        
        // Set writers
        $writers = array(
            'Word2007' => 'docx',
            'ODText' => 'odt',
            'RTF' => 'rtf',
            'HTML' => 'html',
            'PDF' => 'pdf'
        );
        
        // Set PDF renderer
        if (Settings::getPdfRendererPath() === null) {
            $writers['PDF'] = null;
        }
        
        // Return to the caller script when runs by CLI
        if (PHP_SAPI == 'cli') {
            return;
        }
    }

    private function _addDataToRow($table, $template = array(), $styleCell)
    {
        // Add row
        $table->addRow();
        // Add Cell
        $table->addCell(2000)->addText($template['col1']);
        // Add Cell
        $statusCell = $table->addCell(7000, $styleCell);
        $lists = $this->convertToArray($template['col2']);
        foreach ($lists as $values) {
            $statusCellTextRun = $statusCell->createTextRun();
            foreach ($values as $item) {
                if ($item['type'] == 'IMAGE') {
                    $src = trim(str_replace(base_url(), '', $item['src']));
                    $statusCellTextRun->addImage($src);
                } else {
                    $statusCellTextRun->addText('<![CDATA[ ' . htmlspecialchars_decode($item['text']) . ' ]]>');
                }
            }
        }
    }

    private function convertToArray($string)
    {
        // split string via <br>
        $lists = explode('<br>', $string);
        $array = array();
        foreach ($lists as $key => $text) {
            $listStrings = $this->extractStringAndImage($text);
            if (! empty($listStrings)) {
                $arrayString = array();
                foreach ($listStrings as $str) {
                    $image = $this->getImage($str);
                    if (! empty($image)) {
                        $arrayString[] = array(
                            'type' => 'IMAGE',
                            'src' => $image
                        );
                    } else {
                        $arrayString[] = array(
                            'type' => 'TEXT',
                            'text' => $str . ' '
                        );
                    }
                }
                $array[] = $arrayString;
            }
        }
        
        return $array;
    }

    private function getImage($file)
    {
        preg_match('/(?<!_)src=([\'"])?(.*?)\\1/', $file, $matches);
        if (isset($matches[2])) {
            return $matches[2];
        }
        return null;
    }

    private function extractStringAndImage($file)
    {
        preg_match_all('/(<img[^>]*>|([^\s]*[^\s]))/', $file, $matches);
        if (isset($matches[0])) {
            return $matches[0];
        }
        return null;
    }

    private function convertDoubleToSingleQuotes($string)
    {
        return str_replace("\"", "'", $string);
    }
    
    private function addParagraph($section, $text, $bold = false) {
        $lists = $this->convertToArray($text);
        foreach ($lists as $values) {
            $textRun = $section->addTextRun();
            foreach ($values as $item) {
                if ($item['type'] == 'IMAGE') {
                    $src = trim(str_replace(base_url(), '', $item['src']));
                    $textRun->addImage($src);
                } else {
                    $textRun->addText('<![CDATA[ ' . htmlspecialchars_decode($item['text']) . ' ]]>', ['bold' => $bold]);
                }
            }
        }
    }
    
    public function exportTopic($topics, $title) {
        // Include the PHPWord.php, all other classes were loaded by an autoloader
        require_once APPPATH . 'libraries/PhpOffice/PhpWord/PHPWord.php';
        
        // New portrait section
        $styleTable = array(
            'borderSize' => 6,
            'borderColor' => '006699',
            'cellMargin' => 80
        );
        // Add table
        $styleCell = array(
            'valign' => 'center',
            'borderSize' => 6,
            'borderColor' => '006699'
        );
        $array_topic = array();
        try {
            $CI = & get_instance();
            $CI->load->model('topic_model');
            $results = array();
            foreach ($topics as $key => $topic) {
                // New Word Document
                $PHPWord = new \PhpOffice\PhpWord\PhpWord();
                $xmlWriter = IOFactory::createWriter($PHPWord, 'Word2007');
                $section = $PHPWord->createSection();
                // đề thứ i
                $title_topic = 'De ' . $topic['code'] . DOCX;
            
                $data = $CI->topic_model->getData($topic['topic_id']);
                $results[$key]['code'] = $topic['code'];
                $results[$key]['data'] = $data;
                foreach ($data as $item) {
                    $this->addParagraph($section, 'Câu ' . $item['number'] . ': ' . $item['question_name'], true);
                    $answers = explode(SEPARATE_ANSWER, $item['answer']);
                    $num = 65;
                    foreach ($answers as $answer) {
                        $text = chr($num) . '. ' . stripslashes($answer);
                        $this->addParagraph($section, $text);
                        $num ++;
                    }
                }
                
                $filename = BACKEND_V2_DOC_PATH_DIR . $title . '/' . $title_topic;
                $xmlWriter->save($filename);
                $array_topic[] = $filename;
            
                // New Word Document
                $PHPWord = new \PhpOffice\PhpWord\PhpWord();
                $xmlWriter = IOFactory::createWriter($PHPWord, 'Word2007');
                $section = $PHPWord->createSection();
                $table = $section->addTable('myOwnTableStyle');
                // Add table style
                $PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
                // ghi file dap an
                $title_topic = 'De ' . $topic['code'] . " - dap an" . DOCX;
                foreach ($data as $item) {
                    $answers = explode(',', $item['correct_answer']);
                    $num = 65;
                    $convertAnswers = [];
                    foreach ($answers as $i => $answer) {
                        if ($answer) {
                            $convertAnswers[] = chr($num);
                        }
                        $num ++;
                    }
                    $cells = array();
                    $cells['col1'] = 'Câu ' . $item['number'];
                    $cells['col2'] = implode(SEPARATE_CORRECT_ANSWER, $convertAnswers);
                    $this->_addDataToRow($table, $cells, $styleCell);
                }
                $filename = BACKEND_V2_DOC_PATH_DIR . $title . '/' . $title_topic;
                $xmlWriter->save($filename);
                $array_topic[] = $filename;
            }
        } catch(Exception $ex) {
            return $array_topic;
        }
        return $array_topic;
    }

    function exportStorages($filename, $storages)
    {
        // Include the PHPWord.php, all other classes were loaded by an autoloader
        require_once APPPATH . 'libraries/PhpOffice/PhpWord/PHPWord.php';
        
        // New Word Document
        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        // New portrait section
        $section = $PHPWord->createSection();
        
        $styleTable = array(
            'borderSize' => 6,
            'borderColor' => '006699',
            'cellMargin' => 80
        );
        // Add table style
        $PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
        // Add table
        $table = $section->addTable('myOwnTableStyle');
        $styleCell = array(
            'valign' => 'center',
            'borderSize' => 6,
            'borderColor' => '006699'
        );
        for ($i = 0, $n = count($storages); $i < $n; $i ++) {
            $item = $storages[$i];
            
            $list_answer = explode(SEPARATE_ANSWER, $item->answer);
            $list_correct_answer = explode(SEPARATE_CORRECT_ANSWER, $item->correct_answer);
            
            $template = array(
                'col1' => 'Câu hỏi',
                'col2' => trim_all($item->question_name)
            );
            $this->_addDataToRow($table, $template, $styleCell);
            
            $c = 65;
            $index = array();
            foreach ($list_answer as $idx => $answer) {
                if ($list_correct_answer[$idx] == 1) {
                    $index[] = chr($c);
                }
                
                $template = array(
                    'col1' => chr($c ++),
                    'col2' => $answer
                );
                $this->_addDataToRow($table, $template, $styleCell);
            }
            
            $template = array(
                'col1' => 'Câu trả lời đúng',
                'col2' => implode(SEPARATE_CORRECT_ANSWER, $index)
            );
            $this->_addDataToRow($table, $template, $styleCell);
        }
        $xmlWriter = IOFactory::createWriter($PHPWord, 'Word2007');
        $xmlWriter->save($filename);
        $this->export($filename);
    }

    private function _addResultStudentToRow($table, $text, $isTitle = false, $styleText = array())
    {
        
        // Add row
        $table->addRow();
        if ($isTitle) {
            $styleCell = array(
                'borderSize' => 6,
                'borderColor' => '006699',
                'bgColor' => '66BBFF'
            );
            // Add Cell
            $table->addCell(9000, $styleCell)->addText($text, array(
                'bold' => true,
                'color' => 'FFFFFF'
            ));
        } else {
            // Add Cell
            $statusCell = $table->addCell(9000);
            $lists = $this->convertToArray($text);
            foreach ($lists as $values) {
                $statusCellTextRun = $statusCell->createTextRun();
                foreach ($values as $item) {
                    if ($item['type'] == 'IMAGE') {
                        $src = trim(str_replace(base_url(), '', $item['src']));
                        $statusCellTextRun->addImage($src);
                    } else {
                        $statusCellTextRun->addText($item['text'], $styleText);
                    }
                }
            }
        }
    }

    private function _writeInfoStudent($section, $student, $topic)
    {
        $table = $section->addTable('myOwnTableStyle');
        $this->_addResultStudentToRow($table, 'THÔNG TIN CÁ NHÂN', true);
        
        $array[] = 'MSHS: ' . $student->indentity_number;
        $array[] = 'Họ tên: ' . $student->fullname;
        $array[] = 'Lớp: ' . $student->class_name;
        $array[] = 'Đề: ' . $topic->code;
        $text = implode('<br>', $array);
        $this->_addResultStudentToRow($table, $text);
        // <br>
        $section->addTextBreak();
    }

    private function _writeAnswerOfStudent($section, $answers_student)
    {
        $CI = & get_instance();
        $CI->load->library('commonobj');
        
        $table = $section->addTable('myOwnTableStyle');
        $this->_addResultStudentToRow($table, 'CÂU TRẢ LỜI', true);
        $maxCol = 5;
        $n = count($answers_student);
        $plus = $n < $maxCol ? $n : $maxCol;
        
        for ($i = 0; $i < $n; $i += $plus) {
            $array = array();
            for ($j = $i; $j < $i + $plus; $j ++) {
                if ($j < $n) {
                    if(isset($answers_student[$j]['answer'])) {
    					$answers = explode(SEPARATE_CORRECT_ANSWER, $answers_student[$j]['answer']);
    					foreach ($answers as $key => $value) {
    						$answers[$key] = Commonobj::convertNumberToChar((int)$value); 
    					}
    					$answer = implode(SEPARATE_CORRECT_ANSWER, $answers);
                        $array[] = $answers_student[$j]['number_question'] . '. ' . $answer;
                    }
                }
            }
            $text = implode('<br>', $array);
            $this->_addResultStudentToRow($table, $text, false, array(
                'spaceAfter' => 100
            ));
        }
        // <br>
        $section->addTextBreak();
    }

    private function _writeQuestionOrAnswer($statusCell, $text, $styleText)
    {
        $lists = $this->convertToArray($text);
        foreach ($lists as $values) {
            $statusCellTextRun = $statusCell->createTextRun();
            foreach ($values as $item) {
			
                if ($item['type'] == 'IMAGE') {
                    $src = trim(str_replace(base_url(), '', $item['src']));
					// fix for localhost
					$src = DOCUMENT_ROOT . '/' . $src;
				
                    $statusCellTextRun->addImage($src);
                } else {
                    $statusCellTextRun->addText($item['text'], $styleText);
                }
            }
        }
    }

    private function _writeAnswerOfStudentDetail($section, $studentAnswerList, $topicDetails)
    {
        $CI = & get_instance();
        
        $table = $section->addTable('myOwnTableStyle');
        $this->_addResultStudentToRow($table, 'CÂU TRẢ LỜI CHI TIẾT', true);
        
        // Add row
        $table->addRow();
        // add cell
        $statusCell = $table->addCell(9000);
        
        foreach ($topicDetails as $key => $value) {
            $answers = explode('|||', $value['answer']);
            $positions = explode(',', $value['correct_answer']);
            $answer_of_student = @$studentAnswerList[$value['storage_question_id']];
            // write Question
            $this->_writeQuestionOrAnswer($statusCell, ($key + 1) . '. ' . $value['question_name'], array(
                'bold' => true,
                'italic' => true,
                'size' => 16
            ));
            $statusCell->addTextBreak();
            
            if (! isset($answer_of_student['answer'])) {
                $this->_writeQuestionOrAnswer($statusCell, '__ (Không có câu trả lời) __', array(
                    'italic' => true,
                    'size' => 10,
                    'color' => 'FF0000'
                ));
                $statusCell->addTextBreak();
            }
            
            $number = 65;
            foreach ($answers as $k => $v) {
                $correct = '';
				if (isset($answer_of_student['answer'])) {
					$answerOfStudents = explode(SEPARATE_CORRECT_ANSWER, $answer_of_student['answer']);
					if(in_array($k+1, $answerOfStudents)) {
						$correct = "<img src='public/backendV2/assets/images/cross_circle.png' />";
					}
				}
                
                if ($positions[$k]) {
                    $correct = "<img src='public/backendV2/assets/images/tick_circle.png' />";
                }
                // write Answer
                $this->_writeQuestionOrAnswer($statusCell, chr($number ++) . '. ' . $v . ' ' . $correct, array(
                    'size' => 12
                ));
            }
            // <br>
            $statusCell->addTextBreak();
        }
    }

    function exportResultStudent($student, $topic, $student_mark_id = 0)
    {
        $CI = & get_instance();
        
        $topic = (object) $topic;
        
        ob_start();
        $CI->load->library('stringobj');
        $CI->load->library('utils');
        $CI->load->library('commonobj');
        
        $CI->load->model('student_answer_model');
        $CI->load->model('topic_model');
        $CI->load->model('topic_file_model');
        
        $student_id = $student->student_id;
        $student_name = $student->fullname;
        $indentity_number = $student->indentity_number;
        $student_id = intval($student_id);
        
        $data = array(
            'topic_manage_id' => $topic->topic_manage_id,
            'class_id' => $student->class_id
        );
        
        $folderName = $CI->commonobj->encrypt(implode(',', $data));
        $file_path = PATH_FILES_NO_ROOT . $folderName;
        if (! file_exists($file_path)) {
            mkdir($file_path, 0777);
            
            $data['folder_name'] = $folderName;
            $CI->topic_file_model->create_ignore($data);
        }
        $file_path .= '/';
        
        $filename = $file_path . $CI->stringobj->createAlias($student_name, '-') . '-' . $indentity_number . '-' . date('dmYHis') . DOCX;
        
        $answers_student = $CI->student_answer_model->getAnswerOfStudentId($student_id, $topic->topic_id, $student_mark_id);
        $studentAnswerList = $CI->utils->makeList('question_id', $answers_student);
        $topicDetails = $CI->topic_model->getData($topic->topic_id);
        
        // Include the PHPWord.php, all other classes were loaded by an autoloader
        require_once APPPATH . 'libraries/PhpOffice/PhpWord/PHPWord.php';
        
        // New Word Document
        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        // New portrait section
        $section = $PHPWord->createSection();
        
        $styleTable = array(
            'borderSize' => 6,
            'borderColor' => '006699',
            'cellMargin' => 80
        );
        // Add table style
        $PHPWord->addParagraphStyle('pStyle', array(
            'lineHeight' => 2
        ));
        $PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
        
        $this->_writeInfoStudent($section, $student, $topic);
        $this->_writeAnswerOfStudent($section, $answers_student);
        $this->_writeAnswerOfStudentDetail($section, $studentAnswerList, $topicDetails);
        
        // write docx
        $xmlWriter = IOFactory::createWriter($PHPWord, 'Word2007');
        $xmlWriter->save($filename);
    }

    /**
     * allow download word file
     * 
     * @param
     *            $filename
     */
    function export($filename)
    {
        $name = basename($filename);
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header("Content-Disposition: attachment; filename=$name");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        flush();
        readfile($filename);
        
        @unlink($filename);
    }

    function importFromDocx($filename)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $document = $phpWord->loadTemplate($filename);
        // check valid
        $rows = $document->getContentTable();
        if (count($rows) % NUMBER_LINE_A_QUESTION == 0) {
            return $rows;
        }
        return null;
    }
}