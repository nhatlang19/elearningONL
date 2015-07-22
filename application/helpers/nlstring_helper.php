<?php
if(!function_exists('create_title_export')) {
	function create_title_export($str) {
		return preg_replace ( '/[_\/ "]/s', '-', $str );
	}
}

if(!function_exists('trim_all')) {
	function trim_all($str, $charlist = "\t\n\r\0\x0B") {
		return str_replace ( str_split ( $charlist ), '', $str );
	}
}