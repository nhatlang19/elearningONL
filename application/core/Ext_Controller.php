<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ext_Controller extends CI_Controller {

	const _URI_SEGMENT = 4;
	var $url_return = '';

	function __construct() {

		parent::__construct();

		if(!$this->session->userdata('logged_in')) {
			redirect('admin/signin');
		}

		// set header charset of ouput is UTF-8
		$this->output->set_header('Content-Type: text/html; charset=UTF-8');
	}
	
	function getUserInfo() {
		$user = $this->session->userdata('user');
		return $user;
	}

	function __configUpload($path='public/images/products/')
	{
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
		$config['max_size']	= '100000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		return $config;
	}

	function _loadTemnplateAdmin($header = "", $content = "")
	{
		$temp['header'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_header', $header, TRUE);
		$temp['sidebar'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_sidebar', null, TRUE);
		$temp['content'] = $content;
		$temp['footer'] = $this->load->view(BACK_END_INC_TMPL_PATH . 'inc_footer', null, TRUE);
		$this->load->view(BACK_END_TMPL_PATH . 'template', $temp);
	}

	function configPagination($base_url, $total_rows, $per_page=20, $uri_segment = 4)
	{
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['num_links'] = 10;
		$config['uri_segment'] = "$uri_segment";
		$config['first_link'] = '&laquo; First';
		$config['last_link'] = 'Last &raquo;';
		$config['prev_link'] = '&laquo; Previous';
		$config['next_link'] = 'Next &raquo;';
		$config['anchor_class'] = 'class="number"';
		return $config;
	}

	/**
	 * load template file
	 * $header : array header data
	 * $content : content data
	 */
	function _loadTemplate($header="", $content="") {

		// load header template
		$template['header'] = $this->load->view(COMMON_TMPL_PATH . 'header', $header, true);

		$template['content'] = $content;

		// load footer template
		$template['footer'] = $this->load->view(COMMON_TMPL_PATH . 'footer', '', true);

		$this->load->view(COMMON_TMPL_PATH . 'template', $template);
	}
	
	function sendAjax($status = 0, $message = '') {
		$data = array('status' => $status, 'message' => $message);
		echo json_encode($data);
		exit;
	}
}

?>
