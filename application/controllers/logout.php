<?php

class Logout extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $student = $this->session->userdata('studentInfo');
        $this->session->unset_userdata('studentInfo');
        $student_id = $student->student_id;
        $this->session->unset_userdata('topic_' . $student_id);
        redirect('login');
    }
}
?>