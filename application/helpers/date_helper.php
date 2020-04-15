<?php
if (! function_exists('setDate')) {

    function setDate($datestr = '', $format = 'long')
    {
        if ($datestr == '')
            return '--';
        
        $time = strtotime($datestr);
        switch ($format) {
            case 'short':
                $fmt = 'm / d / Y - g:iA';
                break;
            case 'long':
                $fmt = 'F j, Y - g:iA';
                break;
            case 'notime':
                $fmt = 'd.m.Y';
                break;
            case 'time':
                $fmt = 'd.m.Y H:i:s';
                break;
        }
        $newdate = date($fmt, $time);
        return $newdate;
    }
}