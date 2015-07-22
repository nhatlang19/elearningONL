<?php @session_start(); ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		if($this->session->userdata('studentInfo'))
		{
			redirect('exam/quote');
		}
		
		$this->load->library('commonobj');
		
		$this->load->model('student_info_model');
	}
	
	function index() {
		$data = array();
		if($this->input->post()) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if(!$username || !$password) {
				$data['error'] = 'Tên đăng nhập và mật khẩu không hợp lệ';
			}
			$password = $this->commonobj->encrypt($password);
			$student = $this->student_info_model->login($username, $password);
			if($student) {
				$session = array ('studentInfo' => $student );
				$this->session->set_userdata ( $session );
				
				redirect('exam/quote');
			} else {
				$data['error'] = 'Tên đăng nhập và mật khẩu không hợp lệ';
			}
		}
		
		$this->load->view(FRONT_END_TMPL_PATH . 'login', $data);
	}
}