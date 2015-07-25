<?php
trait TemplateTrait
{
    /**
     * load template backend
     * @param array $header set title for page
     * @param string $content set content for page
     * @return void
     */
    protected function loadTemnplateBackend($header = [], $content = "")
    {
        $template['head'] = $this->load->view(BACKEND_V2_INC_TMPL_PATH . 'inc_head', $header, true);
        $template['header'] = $this->load->view(BACKEND_V2_INC_TMPL_PATH . 'inc_header', null, true);
        $template['sidebar'] = $this->load->view(BACKEND_V2_INC_TMPL_PATH . 'inc_sidebar', null, true);
        $template['breadcrumbs'] = $this->load->view(BACKEND_V2_INC_TMPL_PATH . 'inc_breadcrumbs', null, true);
        $template['content'] = $content;
        $template['footer'] = $this->load->view(BACKEND_V2_INC_TMPL_PATH . 'inc_footer', null, true);
        
        $this->load->view(BACKEND_V2_TMPL_PATH . 'template', $template);
    }
    
    /**
     * load template frontend
     * @param string $header set title for page
     * @param string $content set content for page
     * @return void
     */
    protected function loadTemplate($header = "", $content = "")
    {
    
        // load header template
        $template['header'] = $this->load->view(COMMON_TMPL_PATH . 'header', $header, true);
        $template['content'] = $content;
        // load footer template
        $template['footer'] = $this->load->view(COMMON_TMPL_PATH . 'footer', '', true);
    
        $this->load->view(COMMON_TMPL_PATH . 'template', $template);
    }
}