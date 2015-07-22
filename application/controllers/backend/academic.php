<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * class niên học
 * @author nhox
 *
 */
class Academic extends Ext_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('academic_model');

	}

	function lists() {
		$header['title'] = 'Quản lý niên khóa';

		// get data
		$per_page = 10;
		$title = $this->input->post('title');
		$data = array();

		$segment = $this->uri->segment(self::_URI_SEGMENT);

		$base_url = base_url() . BACK_END_TMPL_PATH . 'academic/lists';

		$data['lists'] = $this->academic_model->getAllAcademic($title, $segment, $per_page);

		$config = $this->configPagination($base_url
		, $this->academic_model->table_record_count
		, $per_page, self::_URI_SEGMENT);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination;

		$content = $this->load->view(BACK_END_TMPL_PATH . 'academic/lists', $data, TRUE);
		$this->_loadTemnplateAdmin($header, $content);
	}

	public function edit($id = null) {
		$header['title'] = 'Thêm niên khóa mới';
		$task = 'add';
		
		$data = array();
		if($id) {
			$header['title'] = 'Chỉnh sửa niên khóa';
			$data['academic'] = $this->academic_model->find_by_pkey($id);
			$data['id'] = $id;
			$task = 'edit';
		}
		if($this->input->post()) {
			$id = $this->input->post('id');
			$data['academic_name'] = $this->input->post('academic_name');

			if(!$id) {
				// save into academic table
				$this->academic_model->create($data);
			} else {
				$this->academic_model->update_by_pkey($id, $data);
			}
			unset($data);

			redirect(BACK_END_TMPL_PATH . 'academic/lists');
		}
		
		$data['title'] = $header['title'] ;
		$data['task'] = $task;
		$content = $this->load->view(BACK_END_TMPL_PATH . 'academic/edit', $data, TRUE);
		$this->_loadTemnplateAdmin($header, $content);
	}
}

/* End of file academic.php */
/* Location: ./application/controllers/academic.php */