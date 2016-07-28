<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
function __construct() {
        parent::__construct();
        if($this->session->userdata('login')==FALSE){
            redirect('login');
        }
        
    }

	public function index()
	{
        $data['check']= $this->session->userdata('admin_username');
                $this->load->model('data_model');
               
                $data['users_list']= $this->data_model->users_list();
                $data['user_count_today']= $this->data_model->users_count();
                $data['chat_count']= $this->data_model->chat_count();
                $data['male_count_today']=$this->data_model->male_count_today();
                $data['female_count_today']=$this->data_model->female_count_today();
                $this->load->view('header_new');
		$this->load->view('index_new',$data);
                $this->load->view('footer_new');
	}
        
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */