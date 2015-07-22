<?php
class Utils {
	function ole_excel_reader($uploadpath, $flag = true) {
		@require_once APPPATH . 'libraries/PhpOffice/PHPExcel/IOFactory.php';
		$objPHPExcel = PHPExcel_IOFactory::load ( $uploadpath );
		$sheetData = $objPHPExcel->getActiveSheet ()->toArray ( null, true, true, true );
		if (count ( $sheetData ) && $flag) {
			unset ( $sheetData [1] ); // delete title
		}
		return $sheetData;
	}
	
	function format_title_export_docx($str) {
		return 'public/backend/tmp/' . preg_replace ( '/[_\/ "]/s', '-', $str ) . DOCX;
	}
	
	function makeList($id, $resources) {
		$results = array ();
		foreach ( $resources as $array ) {
			if (isset ( $array [$id] )) {
				$val = $array[$id];
				unset ( $array [$id] );
				foreach ( $array as $k => $value ) {
					$results [$val] [$k] = $value;
				}
			}
		}
		return $results;
	}
}