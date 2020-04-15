<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Created Date : May 30, 2008
 * ClassName : constans_helper.php
 * Sumary : Use define constant value, configure auto load and use anywhere
 * Author :
 * Version : 1.0
 */
 
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('GMT');
}

// number line of a question
define('NUMBER_LINE_A_QUESTION', 6);

define('CACHE_TIME', 300);

define('SCORE_MAX', 10);
define('SCORE_MIN', 0);

define('PER_PAGE', 20);
define('NUM_LINKS', 4);

define('DOCX', '.docx');
define('XLSX', '.xlsx');

define('SEPARATE_ANSWER', '|||');
define('SEPARATE_CORRECT_ANSWER', ',');

define('GROUP_CONCAT_MAX_LENGTH', 1000000);
define('RIGHT_IMAGE', 'public/backendV2/assets/images/tick_circle.png');
define('WRONG_IMAGE', 'public/backendV2/assets/images/cross_circle.png');
/**
 * --------------------------------------------------------------------------
 * Define Path for backend
 * You can find them in system/application/views folder
 * --------------------------------------------------------------------------
 * Use define direction path
 * Usefuly for all controller using this path to load template
 */
if (!empty(getenv("CLEARDB_DATABASE_URL"))) {
    define('ROOT', '');
} else {
    define('ROOT', '/elearningOnline');
}

define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . ROOT);
// BACKUP
define('NAME_BACKUP', 'mybackup_' . date('dmYHis') . '.gz');
define('BACKEND_V2_BACKUP_PATH_ROOT', DOCUMENT_ROOT . '/public/backendV2/backup/');
// FRONTEND
define('FRONT_END_TMPL_PATH', 'frontend/');
define('COMMON_TMPL_PATH', FRONT_END_TMPL_PATH . 'common/');
define('IMAGE_PATH', ROOT . '/public/frontend/images/');
define('JS_PATH', ROOT . '/public/frontend/js/');
define('CSS_PATH', ROOT . '/public/frontend/css/');
define('VENDOR_PATH', ROOT . '/public/frontend/vendor/');

define('PATH_UPLOADS', ROOT . '/public/uploads/');
define('PATH_UPLOADS_NO_ROOT', DOCUMENT_ROOT . '/public/uploads/');
define('PATH_FILES', DOCUMENT_ROOT . '/public/backendV2/files/');
define('PATH_FILES_NO_ROOT', 'public/backendV2/files/');

//////// V2 ///////
define('BACKEND_V2_TMPL_PATH', 'backendV2/');
define('BACKEND_V2_IMAGE_PATH', ROOT . '/public/backendV2/assets/images/');
define('BACKEND_V2_JS_PATH', ROOT . '/public/backendV2/assets/javascripts/');
define('BACKEND_V2_CSS_PATH', ROOT . '/public/backendV2/assets/stylesheets/');
define('BACKEND_V2_VENDOR_PATH', ROOT . '/public/backendV2/assets/vendor/');
define('BACKEND_V2_INC_TMPL_PATH', 'backendV2/inc/');
define('BACKEND_V2_TMP_PATH', ROOT . '/public/backendV2/tmp/');
define('BACKEND_V2_DOC_PATH_DIR', DOCUMENT_ROOT . '/public/backendV2/docs/');
define('BACKEND_V2_EXCEL_PATH_DIR', DOCUMENT_ROOT . '/public/backendV2/xlss/');
define('BACKEND_V2_TMP_PATH_ROOT', DOCUMENT_ROOT . '/public/backendV2/tmp/');
define('BACKEND_V2_TEMPLATES_PATH', ROOT . '/public/backendV2/templates/');
define('BACKEND_V2_TRASH_PATH', DOCUMENT_ROOT . '/public/backendV2/trash');

define('TMPDIR_WORD', '/public/backendV2/tmpdir');

global $config_ckeditor;
$config_ckeditor = array(
    'skin' => 'office2003',
    'toolbar' => array(
        array(
            'Bold',
            'Italic',
            'Underline',
            'Strike',
            '-',
            'Image',
            'Flash',
            'Link',
            'Unlink',
            'Anchor'
        )
    ),
    'filebrowserBrowseUrl' => ROOT . '/public/ckfinder/ckfinder.html',
    'filebrowserImageBrowseUrl' => ROOT . '/public/ckfinder/ckfinder.html?Type=Images',
    'filebrowserFlashBrowseUrl' => ROOT . '/public/ckfinder/ckfinder.html?Type=Flash',
    'filebrowserUploadUrl' => ROOT . '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    'filebrowserImageUploadUrl' => ROOT . '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    'filebrowserFlashUploadUrl' => ROOT . '/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
);

?>