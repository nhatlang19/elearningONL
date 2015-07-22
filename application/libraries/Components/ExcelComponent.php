<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
// date_default_timezone_set('Europe/London');
class ExcelComponent {
	var $CI;
	function __construct() {
		$this->CI =& get_instance();
		
		$this->CI->load->library ( 'PhpOffice/PHPExcel' );
		
		
		if (PHP_SAPI == 'cli') {
			die('This example should only be run from a Web Browser');
		}
	}
	
	function downloadStudentResult($class_id, $delete = false) {
		$this->CI->load->model ( 'student_info_model' );
		$this->CI->load->model ( 'class_model' );
		$this->CI->load->helper('inflector');
		
			
		$class = $this->CI->class_model->find_by_pkey($class_id);
		$listStudent = $this->CI->student_info_model->getMarkStudentsByClass($class_id);
			
		$this->CI->load->library ( 'PhpOffice/PHPExcel' );
		$sheet = $this->CI->phpexcel->getActiveSheet ();
			
		$title_class = underscore ( $class['class_name'] ) . '.xls';
		
		$row = 1;
		// header
		$sheet->setCellValue ( 'A' . $row, 'STT' );
		$sheet->setCellValue ( 'B' . $row, 'Họ tên' );
		$sheet->setCellValue ( 'C' . $row, 'Điểm' );
		$sheet->setCellValue ( 'D' . $row, 'Ghi chú' );
		
		$listIndentities = array();
		foreach ( $listStudent as $key => $student ) {
			++ $row;
			$sheet->setCellValue ( "A$row", $student ['indentity_number'] );
			$sheet->setCellValue ( "B$row", $student ['fullname'] );
			$sheet->setCellValue ( "C$row", (float)$student ['score'] );
			if(in_array($student ['indentity_number'], $listIndentities)) {
				$sheet->setCellValue ( "D$row", "Trùng nhau" );
			} else if(empty($student ['score'] )) {
				$sheet->setCellValue ( "D$row", "Không làm bài" );
			} else {
				$sheet->setCellValue ( "D$row", "" );
			}
			$listIndentities[] = $student ['indentity_number'];
		}
		
		unset ( $sheet );
		
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=\"$title_class\"");
		$writer = new PHPExcel_Writer_Excel5($this->CI->phpexcel);
		$writer->save('php://output');

// 		// Redirect output to a client’s web browser (Excel2007)
// 		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// 		header('Content-Disposition: attachment;filename="01simple.xls"');
// 		header('Cache-Control: max-age=0');
// 		// If you're serving to IE 9, then the following may be needed
// 		header('Cache-Control: max-age=1');
		
// 		// If you're serving to IE over SSL, then the following may be needed
// 		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
// 		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
// 		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
// 		header ('Pragma: public'); // HTTP/1.0
		
// 		$objWriter = PHPExcel_IOFactory::createWriter($this->CI->phpexcel, 'Excel2007');
// 		$objWriter->save('php://output');
	}
}