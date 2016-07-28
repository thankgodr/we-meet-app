<?php

class settings extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('login') == FALSE) {
            redirect('login');
        } else {
            $this->load->model('data_model');
        }
    }

    public function index() {

        $this->load->view('header_new');
        $this->load->view('setting');
        $this->load->view('footer_new');
    }

    public function addadmin() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $confirm = $this->input->post('repassword');
        //echo $password;
        
        
        
        if ($this->data_model->addadmin($username, $password, $confirm)) {
            
            $this->session->set_flashdata('message', 'Admin Added Sucessfully');
            redirect("settings");
        } else {

            $this->session->set_flashdata('message', 'Password Not Match');


            redirect("settings");
        }
    
   
    }
   

}
