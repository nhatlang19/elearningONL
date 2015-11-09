<?php

class Utils
{
    public function getLocalIp() {
        $CI = & get_instance();
        $ip = $CI->input->ip_address();
        if($ip == '::1') {
            $ip = getHostByName(getHostName());
        }
        return $ip;
    }
    
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
        return trim( $this->remove_doublewhitespace( $this->remove_whitespace_feed($s) ) );
    }
    
    public function oleExcelReader($uploadpath, $flag = true)
    {
        @require_once APPPATH . 'libraries/PhpOffice/PHPExcel/IOFactory.php';
        $objPHPExcel = PHPExcel_IOFactory::load($uploadpath);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        if (count($sheetData) && $flag) {
            unset($sheetData[1]); // delete title
        }
        return $sheetData;
    }

    public function formatTitleExportDocx($str)
    {
        return BACKEND_V2_TMP_PATH_ROOT . preg_replace('/[_\/ "]/s', '-', $str) . DOCX;
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