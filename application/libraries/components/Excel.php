<?php
use App\Libraries\Excel\PhpExcelSingleton;

use App\Libraries\AppComponent;
require_once APPPATH . 'libraries/components/AppComponent.php';

class Excel extends AppComponent
{
    private $phpExcel;

    public function __construct()
    {
        parent::__construct();

        $this->phpExcel = PhpExcelSingleton::getInstance();
    }

    public function downloadStudentResult($class_id, $topic_manage_id)
    {
        $this->CI->load->model('student_info_model');
        $this->CI->load->model('class_model');
        $this->CI->load->model('topic_model');
        $this->CI->load->model('student_mark_model');

        $this->CI->load->helper('inflector');

        $this->CI->load->library(['utils']);

        $class = $this->CI->class_model->find_by_pkey($class_id);
        $topic = $this->CI->topic_model->getTopicIdByTopicManageId($topic_manage_id);
        $topics = array_filter(array_map('trim', explode(',', $topic->topic_id)));

        $studentsMark = $this->CI->student_mark_model->getMarkStudents($topics, $class_id);
        $studentsMark = $this->CI->utils->makeList('student_id', $studentsMark);
        $students = $this->CI->student_info_model->getAllStudents($class_id);

        $sheet = $this->phpExcel->getActiveSheet();
        $title_class = underscore($class->class_name) . '.xls';

        $row = 1;
        // header
        $sheet->setCellValue('A' . $row, 'STT');
        $sheet->setCellValue('B' . $row, 'Họ tên');
        $sheet->setCellValue('C' . $row, 'Điểm');
        $sheet->setCellValue('D' . $row, 'Ghi chú');
        $sheet->setCellValue('E' . $row, 'IP');

        $listIndentities = array();
        $ipList = array();
        foreach ($students as $key => $student) {
            ++ $row;
            $sheet->setCellValue("A$row", $student->indentity_number);
            $sheet->setCellValue("B$row", $student->fullname);
            if(isset($studentsMark[$student->student_id])) {
                $resultOfStudent = $studentsMark[$student->student_id];
                if(!empty($resultOfStudent->ip_address) && in_array($resultOfStudent->ip_address, $ipList)) {
                    $sheet->setCellValue("D$row", "Trùng địa chỉ IP");
                } else {
                    $sheet->setCellValue("D$row", "");
                    $ipList[] = $resultOfStudent->ip_address;
                }
                $sheet->setCellValue("E$row", $resultOfStudent->ip_address);
                $sheet->setCellValue("C$row", (float) $resultOfStudent->score);
            } else {
                $sheet->setCellValue("D$row", "Chưa làm bài");
                $sheet->setCellValue("C$row", "");
            }

            if (in_array($student->indentity_number, $listIndentities)) {
                $sheet->setCellValue("D$row", "Trùng mã số học sinh");
            }
            $listIndentities[] = $student->indentity_number;

        }
        unset($sheet);
        $this->phpExcel->downloadExcel($title_class);
    }
}
