<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package CodeIgniter
 * @author ExpressionEngine Dev Team
 * @copyright Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license http://codeigniter.com/user_guide/license.html
 * @link http://codeigniter.com
 * @since Version 1.0
 * @filesource
 *
 */
    
// ------------------------------------------------------------------------

/**
 * CodeIgniter Download Helpers
 *
 * @package CodeIgniter
 * @subpackage Helpers
 * @category Helpers
 * @author ExpressionEngine Dev Team
 * @link http://codeigniter.com/user_guide/helpers/download_helper.html
 */
    
// ------------------------------------------------------------------------

/**
 * Force Download
 *
 * Generates headers that force a download to happen
 *
 * @access public
 * @param
 *            string filename
 * @param
 *            mixed the data to be downloaded
 * @return void
 */
if (! function_exists('my_force_download')) {

    function my_force_download($filename = '', $zip = '')
    {
        $mime = 'application/octet-stream';
        
        // Generate the server headers
        if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== FALSE) {
            header('Content-Type: "' . $mime . '"');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header("Content-Transfer-Encoding: binary");
            header('Pragma: public');
        } else {
            header('Content-Type: "' . $mime . '"');
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-disposition: attachment; filename="' . $filename . '"');
        }
        readfile($zip);
    }
}


/* End of file download_helper.php */
/* Location: ./application/helpers/download_helper.php */