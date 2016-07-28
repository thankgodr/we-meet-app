<?php

class data_controller extends CI_Controller{
    
     function __construct() {
        parent::__construct();
        if($this->session->userdata('login')==FALSE){
            echo "403 Forbidden Authentication Failed";
        }
        else{
                    $this->load->model('data_model');
        }
        
    }
    public function new_users_count(){
       $day[1]= $this->data_model->users_count_date(date("Y-m-d",strtotime(' -6 day')));
       $day[2]= $this->data_model->users_count_date(date("Y-m-d",strtotime(' -5 day')));
        $day[3]= $this->data_model->users_count_date(date("Y-m-d",strtotime(' -4 day')));
         $day[4]= $this->data_model->users_count_date(date("Y-m-d",strtotime(' -3 day')));
          $day[5]= $this->data_model->users_count_date(date("Y-m-d",strtotime(' -2 day')));
           $day[6]= $this->data_model->users_count_date(date("Y-m-d",strtotime(' -1 day')));
            $day[7]= $this->data_model->users_count_date(date("Y-m-d"));
 
      
        $array = array($day[1],$day[2],$day[3],$day[4],$day[5],$day[6],$day[7]);
        echo json_encode($array);
    }
       public function new_male_users_count(){

       $day[1]= $this->data_model->new_male_users_count(date("Y-m-d",strtotime(' -6 day')));
       $day[2]= $this->data_model->new_male_users_count(date("Y-m-d",strtotime(' -5 day')));
        $day[3]= $this->data_model->new_male_users_count(date("Y-m-d",strtotime(' -4 day')));
         $day[4]= $this->data_model->new_male_users_count(date("Y-m-d",strtotime(' -3 day')));
          $day[5]= $this->data_model->new_male_users_count(date("Y-m-d",strtotime(' -2 day')));
           $day[6]= $this->data_model->new_male_users_count(date("Y-m-d",strtotime(' -1 day')));
            $day[7]= $this->data_model->new_male_users_count(date("Y-m-d"));
 
      
        $array = array($day[1],$day[2],$day[3],$day[4],$day[5],$day[6],$day[7]);
        echo json_encode($array);
    }
        public function new_female_users_count(){

       $day[1]= $this->data_model->new_female_users_count(date("Y-m-d",strtotime(' -6 day')));
       $day[2]= $this->data_model->new_female_users_count(date("Y-m-d",strtotime(' -5 day')));
        $day[3]= $this->data_model->new_female_users_count(date("Y-m-d",strtotime(' -4 day')));
         $day[4]= $this->data_model->new_female_users_count(date("Y-m-d",strtotime(' -3 day')));
          $day[5]= $this->data_model->new_female_users_count(date("Y-m-d",strtotime(' -2 day')));
           $day[6]= $this->data_model->new_female_users_count(date("Y-m-d",strtotime(' -1 day')));
            $day[7]= $this->data_model->new_female_users_count(date("Y-m-d"));
 
      
        $array = array($day[1],$day[2],$day[3],$day[4],$day[5],$day[6],$day[7]);
        echo json_encode($array);
    }
    
    
    public function delete_user(){
        //$eid=$this->input->post('eid');
           $eid=$this->input->post('customcheckbox1');
//print_R($eid);
        
        
       if($this->data_model->delete_user($eid)){
            redirect('users');
            
        }
        else{
            echo 'failed';
        }
       
    }
    
    
    
  
}

