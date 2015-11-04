<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
include_once APPPATH . 'helpers/Traits/TemplateTrait.php';
include_once APPPATH . 'helpers/Traits/PaginateTrait.php';
include_once APPPATH . 'helpers/Traits/ExportCsvTrait.php';

class Ext_Controller extends CI_Controller
{
    use TemplateTrait;
    use PaginateTrait;
    use ExportCsvTrait;
    
    const URI_SEGMENT = 4;

    var $url_return = '';
    protected $mainModel = '';
    
    public function __construct()
    {
        parent::__construct();
        
        if (! $this->session->userdata('logged_in')) {
            redirect('admin/signin');
        }
        
        // set header charset of ouput is UTF-8
        $this->output->set_header('Content-Type: text/html; charset=UTF-8');
    }

    protected function getUserInfo()
    {
        return $this->session->userdata('user');
    }

    protected function __configUpload($path = 'public/images/products/')
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
        $config['max_size'] = '100000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        return $config;
    }

    protected function sendAjax($status = 0, $message = '', $data = [])
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
        
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    
    public function index() {
        $controller = $this->uri->segment(2);
        redirect(BACKEND_V2_TMPL_PATH . $controller . '/lists' ); 
    }
    
    public function delete($id = null) {
        if(empty($this->mainModel)) {
            throw new Exception('Undefined mainModel in Controller');
        }
        if($this->input->is_ajax_request() && $id) {
            $id = intval($id);
            $this->{$this->mainModel}->deleteById($id);
            
            $this->lphcache->cleanCacheByFunction($this->{$this->mainModel}->table_name, 'getAll');
            $this->sendAjax();
        } else {
            show_404();
        }
    }
}

?>
