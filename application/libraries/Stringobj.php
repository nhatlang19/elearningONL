<?php

class Stringobj
{
    function _mktime($str)
    {
        $arr = explode('/', $str);
        $mk = mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]);
        return date('Y-m-d', $mk);
    }

    function convertUTF8($string)
    {
        $string = mb_convert_encoding($string, 'UTF-8');
        $string = html_entity_decode($string, ENT_QUOTES, "UTF-8");
        return $string;
    }

    function getImage($file)
    {
        preg_match('/(?<!_)src=([\'"])?(.*?)\\1/', $file, $matches);
        if (isset($matches[2])) {
            return $matches[2];
        }
        return null;
    }

    function extractStringAndImage($file)
    {
        preg_match_all('/(<img[^>]*>|([^\s]*[^\s]))/', $file, $matches);
        if (isset($matches[0])) {
            return $matches[0];
        }
        return null;
    }

    function introContent($text, $length = 200)
    {
        $text = preg_replace("'<script[^>]*>.*?</script>'si", "", $text);
        $text = preg_replace('/{.+?}/', '', $text);
        $text = strip_tags(preg_replace("'<(br[^/>]*?/|hr[^/>]*?/|/(div|h[1-6]|li|p|td))>'si", ' ', $text));
        if (strlen($text) > $length) {
            $text = substr($text, 0, strpos($text, ' ', $length)) . "...";
        }
        return $text;
    }

    function UTF8Encode($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        // $str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        return $str;
    }

    function removeCharacter($str)
    {
        $str = preg_replace('/[^a-zA-Z0-9_"]/s', '', $str);
        return $str;
    }

    function createAlias($str, $char = '-')
    {
        $encode = strtolower(self::UTF8Encode(trim($str)));
        $array_str = explode(' ', $encode);
        $result = implode($char, $array_str);
        $result = self::removeCharacter($result);
        return $result;
    }
}