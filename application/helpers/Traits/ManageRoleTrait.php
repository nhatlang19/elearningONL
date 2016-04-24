<?php
trait ManageRoleTrait
{
    /**
     * return menu config
     */
    private function loadMenuConfig() {
        // load sidebar config
        $this->config->load('el-sidebar');
        $menu = $this->config->item('menu');
        return $menu;
    }
    
    public function allowPermissions($allowActions = array()) {
        $menu = $this->loadMenuConfig();
        $controller = $this->uri->segment(2);
        $action = $this->uri->segment(3);
        
        $user = $this->session->userdata('user');
        if(in_array($action, $allowActions)) {
            return true;
        }
        
        if(isset($menu[$controller])) {
            $roles = $menu[$controller]['role'];
            $visible = $menu[$controller]['visible'];
            if (in_array($user->role, $roles) && $visible) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
}