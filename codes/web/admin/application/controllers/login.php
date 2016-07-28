<?php

class login extends CI_Controller {

    public function index() {

        if ($this->session->userdata('login') == TRUE) {
            redirect('welcome');
        }

        $this->load->view('css_header');
        $this->load->view('login');
        $this->load->view('footer_new');
        $this->load->library('session');
    }

    public function check() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_VerifyUser');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('message', 'UserName OR Password Incorrect');
            redirect('login');
        } else {

            redirect('welcome');
        }
    }

    public function VerifyUser() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->load->model('model_login');
        if ($this->model_login->login($username, $password)) {


            $this->session->set_userdata('login', TRUE);

            return true;
        } else {
            $this->form_validation->set_message('VerifyUser', 'Incorrect Combination');
            return false;
        }
    }

    public function logout() {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('user_id');
        redirect('welcome');
    }

}
