<?php
if (! function_exists('create_title_export')) {

    function create_title_export($str)
    {
        return preg_replace('/[_\/ "]/s', '-', $str);
    }
}

if (! function_exists('trim_all')) {

    function trim_all($str, $charlist = "\t\n\r\0\x0B")
    {
        $str = preg_replace( "/\s+/", " ", $str );
        return trim(str_replace(str_split($charlist), '', $str));
    }
}

if (! function_exists('debug')) {

    function debug($str)
    {
        echo '<pre>';
        print_r($str);
        echo '</pre>';
        echo "\n";
    }
}

function sanitizeText($string) {
//     $title = stripslashes($title);
//     $title = nl2br($title);
//     $title = strip_tags($title);

    $string = filter_var($string, FILTER_SANITIZE_STRING);
    return trim($string);
}

