<?php

class Utils
{
    public function remove_doublewhitespace($s = null){
        return  $ret = preg_replace('/([\s])\1+/', ' ', $s);
    }
    
    public function remove_whitespace($s = null){
        return $ret = preg_replace('/[\s]+/', '', $s );
    }
    
    public function remove_whitespace_feed( $s = null){
        return $ret = preg_replace('/[\t\n\r\0\x0B]/', '', $s);
    }
    
    public function smart_clean($s = null){
        return $ret = trim( $this->remove_doublewhitespace( $this->remove_whitespace_feed($s) ) );
    }
    
    public function ole_excel_reader($uploadpath, $flag = true)
    {
        @require_once APPPATH . 'libraries/PhpOffice/PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($uploadpath);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        if (count($sheetData) && $flag) {
            unset($sheetData[1]); // delete title
        }
        return $sheetData;
    }

    public function format_title_export_docx($str)
    {
        return 'public/backend/tmp/' . preg_replace('/[_\/ "]/s', '-', $str) . DOCX;
    }

    public function makeList($id, $resources)
    {
        $results = array();
        foreach ($resources as $array) {
            if (isset($array[$id])) {
                $val = $array[$id];
                unset($array[$id]);
                foreach ($array as $k => $value) {
                    $results[$val][$k] = $value;
                }
            }
        }
        return $results;
    }
}