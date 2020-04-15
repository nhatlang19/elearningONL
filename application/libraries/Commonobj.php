<?php
if (! class_exists('Commonobj')) {

    class Commonobj
    {

        public function deleteDir($dirPath)
        {
            if (! is_dir($dirPath)) {
                throw new InvalidArgumentException("$dirPath must be a directory");
            }
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteDir($file);
                } else {
                    @unlink($file);
                }
            }
            @rmdir($dirPath);
        }

        public function getIpAddress()
        {
            $CI = & get_instance();
            if ($CI->input->ip_address() == '::1') { // is localhost
                $exec = exec("hostname");
                $hostname = trim($exec);
                return gethostbyname($hostname);
            }
            return $CI->input->ip_address();
        }

        public static function encrypt($string)
        {
            // $CI = & get_instance();
            // $CI->load->library('encrypt');
            
//             $hash = $CI->encrypt->sha1($string);
            $hash = md5($string);
            return $hash;
        }

        /**
         * Hàm tính điểm
         * 
         * @param int $total_score
         *            số điểm tối đa ( 10 )
         * @param int $number_question
         *            tổng số câu hỏi
         * @param int $number_correct
         *            số câu trả lời đúng
         * @return int điểm (đã làm tròn)
         */
        public function funcScoring($total_score, $number_question, $number_correct)
        {
            return round($total_score / $number_question * $number_correct, 2);
        }

        public static function findCorrectIndex($array)
        {
            $idx = 0;
            foreach ($array as $value) {
                if ($value == 1)
                    break;
                $idx ++;
            }
            return $idx + 1;
        }

        public static function convertNumberToChar($number)
        {
            $number = intval($number);
            $lists = array(
                'A' => 1,
                'B' => 2,
                'C' => 3,
                'D' => 4,
                'E' => 5
            );
            return array_search($number, $lists);
        }

        public static function convertCharToNumber($char = 'A')
        {
            $char = strtoupper($char);
            $lists = array(
                '',
                'A',
                'B',
                'C',
                'D',
                'E',
                'F',
                'G'
            );
            return array_search($char, $lists);
        }

        public static function TrimAll($str, $charlist = "\t\n\r\0\x0B")
        {
            return str_replace(str_split($charlist), '', $str);
        }

        public static function pause()
        {
            $time1 = 4000000;
            $time2 = 8000000;
            usleep(rand($time1, $time2));
        }

        public static function formatNumber($number)
        {
            return number_format($number);
        }

        public static function parseDate($rangeDate)
        {
            $date = explode('to', $rangeDate);
            $steps = 0;
            
            $post_array = array();
            
            if (! isset($date[1])) {
                $dateLabel = new DateTime(date('Y/m/d'));
                return self::setDate($rangeDate);
            } else {
                $dateLabel = new DateTime(date('Y/m/d'));
                return self::setDate(trim($date[0])) . ' to ' . self::setDate(trim($date[1]));
            }
        }

        public static function convertDate($rangeDate, $format = 'notime')
        {
            $date = explode('to', $rangeDate);
            $steps = 0;
            
            $post_array = array();
            
            if (! isset($date[1])) {
                return self::setDate($rangeDate, $format);
            } else {
                return self::setDate(trim($date[0]), $format) . ' to ' . self::setDate(trim($date[1]), $format);
            }
        }

        public static function setDate($datestr = '', $format = 'notime')
        {
            if ($datestr == '')
                return '--';
            
            $time = strtotime($datestr);
            switch ($format) {
                case 'short':
                    $fmt = 'd/m/Y H:i';
                    break;
                case 'long':
                    $fmt = 'H:i A - d.m.Y';
                    break;
                case 'y/m/d':
                    $fmt = 'Y/m/d';
                    break;
                case 'notime':
                    $fmt = 'd.m.Y';
                    break;
            }
            $newdate = date($fmt, $time);
            return $newdate;
        }

        public function gen_password($length = 6)
        {
            $password = "";
            mt_srand((double) microtime() * 1000000); // random number inizializzation
            for ($i = 0; $i < $length; $i ++) {
                if ($i % 2 == 0)
                    $password .= chr(mt_rand(97, 122));
                else
                    $password .= chr(mt_rand(48, 57));
            }
            return $password;
        }

        public function genRandomString($length = 5)
        {
            $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $str = '';
            for ($i = 0; $i < $length; $i ++) {
                $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
            }
            
            return $str;
        }

        public function is_ajax_request()
        {
            return (! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        }

        public function encode($str)
        {
            $result = base64_encode($str);
            $result = str_replace("=", "$", $result);
            $result = str_replace("/", "@", $result);
            return strrev($result);
        }

        public function decode($str)
        {
            $rev = strrev($str);
            $result = str_replace("@", "/", $rev);
            $result = str_replace("$", "=", $rev);
            $result = base64_decode($result);
            return $result;
        }

        public function display_filesize($filesize)
        {
            if ($filesize != 0) {
                if ($filesize >= 1099511627776) {
                    $fsize = number_format($filesize / 1099511627776, 2, ',', '.') . ' TB';
                } else 
                    if ($filesize >= 1073741824) {
                        $fsize = number_format($filesize / 1073741824, 2, ',', '.') . ' GB';
                    } else 
                        if ($filesize >= 1048576) {
                            $fsize = number_format($filesize / 1048576, 2, ',', '.') . ' MB';
                        } else {
                            $fsize = number_format($filesize / 1024, 2, ',', '.') . ' KB';
                        }
            } else {
                $fsize = "";
            }
            return $fsize;
        }

        public function path_encode($str, $root_dir = '/')
        {
            $result = str_replace("../", "", $str);
            return str_replace($root_dir . "app/webroot/", "DYNAMIC_PATH/", $result);
        }

        public function path_decode($str, $path)
        {
            return str_replace("DYNAMIC_PATH/", $path, $str);
        }

        public function make_img_post_dir($dir, $create_thumb = NULL)
        {
            if (! file_exists($dir)) {
                @mkdir($dir, 0777);
                if ($create_thumb)
                    @mkdir($dir . '/_thumbs', 0777);
            }
        }

        public function set_add($set, $item)
        {
            $items = explode(',', $set);
            if (in_array($item, $items)) {
                return $set;
            } else {
                $items[] = $item;
                return trim(implode(',', $items), ' ,');
            }
        }

        public function set_forceadd($set, $item)
        { // echo $set."---".$item; die();
            $items = explode(',', $set);
            if (in_array($item, $items)) {
                return $set;
            } else {
                $new_items = array();
                if (count($items) < 4) {
                    for ($i = 0; $i < count($items); $i ++)
                        $new_items[] = $items[$i];
                } else {
                    for ($i = 1; $i < 4; $i ++)
                        $new_items[] = $items[$i];
                }
                $new_items[] = $item;
                return trim(implode(',', $new_items), ' ,');
            }
        }

        public function set_remove($set, $item)
        {
            $items = explode(',', $set);
            if (! in_array($item, $items)) {
                return $set;
            } else {
                $new_items = array();
                foreach ($items as $i) {
                    if ($i != $item)
                        $new_items[] = $i;
                }
                return trim(implode(',', $new_items), ' ,');
            }
        }

        public function is_username($username, $min_length = 5, $max_length = 20)
        {
            if (preg_match('/^[a-z\d_]{' . $min_length . ',' . $max_length . '}$/i', $username))
                return true;
            return false;
        }

        public function is_phone($phone)
        {
            if (strlen($phone) < 7)
                return false;
            
            $valid_chars = "0123456789-+() ";
            $chars = array();
            $len = strlen($valid_chars);
            for ($i = 0; $i < $len; $i ++)
                $chars[] = $valid_chars[$i];
            $len = strlen($phone);
            for ($i = 0; $i < $len; $i ++) {
                if (! in_array($phone[$i], $chars))
                    return false;
            }
            return true;
        }

        function upload_file($file_upload, $new_filename = '', $file_types, $max_size, $filename_valid_chars, $destination, &$message)
        {
            if ($_FILES[$file_upload]['name']) {
                if (! in_array($_FILES[$file_upload]["type"], $file_types)) {
                    $message = "File type is invalid.";
                    return '';
                } else 
                    if (($_FILES[$file_upload]["size"] > $max_size)) {
                        $message = "File size too big.";
                        return '';
                    } else {
                        $ffilename = basename($_FILES[$file_upload]['name']);
                        $pointPosition = strrpos($ffilename, ".");
                        $name = substr($ffilename, 0, $pointPosition);
                        $ext = substr($ffilename, $pointPosition + 1, strlen($ffilename) - $pointPosition - 1);
                        
                        if ($new_filename != '') {
                            $newfilename = $new_filename . '.' . $ext;
                        } else {
                            // Cắt bớt phần tên còn 30 kí tự nếu tên file quá dài
                            if (strlen($name) > 30)
                                $name = substr($name, 0, 30);
                                
                                // Xử lý những kí tự không hợp lệ trong tên file / Xử lý upload script (thay dấu . thành dấu _)
                            for ($i = 0; $i < strlen($name); $i ++) {
                                if (strpos($filename_valid_chars, $name[$i]) === false)
                                    $name = str_replace($name[$i], "-", $name);
                            }
                            // Xử lý trùng tên file
                            $dest = $destination . $name . "." . $ext;
                            $fileName = $name . "." . $ext;
                            
                            while (file_exists($dest)) {
                                srand((double) microtime() * 1000000); // random number inizializzation
                                $fileName = $name . rand(1, 9999) . "." . $ext; // add number to file name
                                $dest = $destination . $fileName; // full destination path to images dir
                            }
                            $newfilename = $fileName;
                        }
                        
                        if (! @is_uploaded_file($_FILES[$file_upload]['tmp_name'])) {
                            $message = "Upload file error.";
                            return '';
                        }
                        
                        if (! @move_uploaded_file($_FILES[$file_upload]['tmp_name'], $destination . $newfilename)) {
                            $message = "Can't write file, please check folder's permission.";
                            return '';
                        }
                        return $newfilename;
                    }
            } else {
                return "";
            }
        }

        function resize_crop($dir_path_source, $dir_path_dest, $oldfilename, $newfilename = '', $width, $height, &$message)
        {
            require_once ('phpThumb_1.7.9/phpthumb.class.php');
            
            if ($newfilename != '') {
                $pointPosition = strrpos($newfilename, ".");
                $name = substr($newfilename, 0, $pointPosition);
                $ext = substr($newfilename, $pointPosition + 1, strlen($newfilename) - $pointPosition - 1);
                $newfilename = newfilename . '.' . $ext;
            } else {
                $newfilename = $oldfilename;
            }
            
            $phpThumb = new phpThumb();
            // $phpThumb->setSourceData(file_get_contents($_FILES[$file_name]['tmp_name']));
            $phpThumb->setSourceFilename($dir_path_source . $oldfilename);
            $phpThumb->setParameter('zc', true);
            
            $output_filename = $dir_path_dest . $newfilename;
            $phpThumb->setParameter('w', $width);
            $phpThumb->setParameter('h', $height);
            $phpThumb->setParameter('is_alpha', true);
            
            // generate & output thumbnail
            if ($phpThumb->GenerateThumbnail()) { // this line is VERY important, do not remove it!
                if ($phpThumb->RenderToFile($output_filename)) {
                    // do something on success
                } else {
                    // do something with debug/error messages
                    $message = "Render file bị lỗi.";
                    return false;
                    
                    // echo 'Failed:<pre>'.implode("\n\n", $phpThumb->debugmessages).'</pre>';
                }
            } else {
                // do something with debug/error messages
                $message = "Resize / Crop file bị lỗi.";
                return false;
                
                // echo 'Failed:<pre>'.$phpThumb->fatalerror."\n\n".implode("\n\n", $phpThumb->debugmessages).'</pre>';
            }
            
            return true;
        }

        /**
         * do string cut
         *
         * @param string $pStr
         *            - The string to be cut
         * @param intefer $pMaxLen
         *            - The maximum length cut
         * @return string
         */
        public function cut($pStr, $pMaxLen = 40)
        {
            // filter all the tags
            $filter = new Zend_Filter_StripTags();
            $pStr = trim($filter->filter($pStr));
            $returnStr = $this->cutstr($pStr, $pMaxLen, '...');
            return $returnStr;
        }

        /**
         * cut string, utf8 by default
         *
         * @param $string -
         *            string to cut
         * @param $length -
         *            Max length to cut
         * @param $dot -
         *            the tail added to the sub-string
         * @param $encoding -
         *            the encoding of string
         * @return string
         */
        public function cutstr($string, $length, $dot = '...', $encoding = 'utf8')
        {
            if (strlen($string) <= $length) {
                return $string;
            }
            
            $strcut = '';
            if (strtolower($encoding) == 'utf8') {
                $n = $tn = $noc = 0;
                while ($n < strlen($string)) {
                    $t = ord($string[$n]);
                    if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                        $tn = 1;
                        $n ++;
                        $noc ++;
                    } elseif (194 <= $t && $t <= 223) {
                        $tn = 2;
                        $n += 2;
                        $noc += 2;
                    } elseif (224 <= $t && $t < 239) {
                        $tn = 3;
                        $n += 3;
                        $noc += 2;
                    } elseif (240 <= $t && $t <= 247) {
                        $tn = 4;
                        $n += 4;
                        $noc += 2;
                    } elseif (248 <= $t && $t <= 251) {
                        $tn = 5;
                        $n += 5;
                        $noc += 2;
                    } elseif ($t == 252 || $t == 253) {
                        $tn = 6;
                        $n += 6;
                        $noc += 2;
                    } else {
                        $n ++;
                    }
                    if ($noc >= $length) {
                        break;
                    }
                }
                if ($noc > $length) {
                    $n -= $tn;
                }
                $strcut = substr($string, 0, $n);
            } else {
                for ($i = 0; $i < $length - strlen($dot) - 1; $i ++) {
                    if (ord($string[$i]) > 127) {
                        $strcut .= $string[$i] . $string[++ $i];
                    } else {
                        $strcut .= $string[$i];
                    }
                }
            }
            
            return $strcut . $dot;
        }

        function isDateValid($str)
        {
            $stamp = strtotime($str);
            if (! is_numeric($stamp))
                return FALSE;
                
                // checkdate(month, day, year)
            if (checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp))) {
                return TRUE;
            }
            return FALSE;
        }

        /**
         *
         * @return : javascript String
         */
        public static function popupEmail($title = 'win-popup', $width = 400, $height = 350)
        {
            return "window.open(this.href,'$title','width=$width,height=$height,titlebar=no,menubar=no,resizable=yes'); return false;";
        }

        public static function checkCompareBrand($post)
        {
            if (isset($post['cbrand'])) {
                $brand = $post['cbrand'];
                $list = explode(',', $brand);
                if (count($list) == 1 && $list[0] == - 1)
                    return false;
                return true;
            }
            return false;
        }
    }
}
?>