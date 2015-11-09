<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
// date_default_timezone_set('Europe/London');

use App\Libraries\AppComponent;
require_once APPPATH . 'libraries/components/AppComponent.php';
class Excel extends AppComponent
{

    function __construct()
    {
        parent::__construct();
        
        $this->CI->load->library('PhpOffice/PHPExcel');
        
        if (PHP_SAPI == 'cli') {
            die('This example should only be run from a Web Browser');
        }
    }

    function downloadStudentResult($class_id, $delete = false)
    {
        $this->CI->load->model('student_info_model');
        $this->CI->load->model('class_model');
        $this->CI->load->helper('inflector');
        
        $class = $this->CI->class_model->find_by_pkey($class_id);
        $listStudent = $this->CI->student_info_model->getMarkStudentsByClass($class_id);
        
        $this->CI->load->library('PhpOffice/PHPExcel');
        $sheet = $this->CI->phpexcel->getActiveSheet();
        
        $title_class = underscore($class->class_name) . '.xls';
        
        $row = 1;
        // header
        $sheet->setCellValue('A' . $row, 'STT');
        $sheet->setCellValue('B' . $row, 'Họ tên');
        $sheet->setCellValue('C' . $row, 'Điểm');
        $sheet->setCellValue('D' . $row, 'Ghi chú');
        
        $listIndentities = array();
        foreach ($listStudent as $key => $student) {
            $student = (array)$student; 
            ++ $row;
            $sheet->setCellValue("A$row", $student['indentity_number']);
            $sheet->setCellValue("B$row", $student['fullname']);
            if (in_array($student['indentity_number'], $listIndentities)) {
                $sheet->setCellValue("D$row", "Trùng nhau");
            } 
            
            if (empty($student['score'])) {
                $sheet->setCellValue("D$row", "Chưa làm bài");
                $sheet->setCellValue("C$row", "");
            } else {
                $sheet->setCellValue("D$row", "");
                $sheet->setCellValue("C$row", (float) $student['score']);
            }
            $listIndentities[] = $student['indentity_number'];
        }
        
        unset($sheet);
        
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=\"$title_class\"");
        $writer = new PHPExcel_Writer_Excel5($this->CI->phpexcel);
        $writer->save('php://output');
        
    }
}