<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reportedusers extends CI_Controller {

 function __construct() {
        parent::__construct();
        if($this->session->userdata('login')==FALSE){
            redirect('login');
        }
       
    }
	public function index()
	{
                $this->load->model('data_model');
                $data['users_list']= $this->data_model->users_list();
                $this->load->view('header');
		$this->load->view('r_users',$data);
                $this->load->view('footer');
	}
        
        
}