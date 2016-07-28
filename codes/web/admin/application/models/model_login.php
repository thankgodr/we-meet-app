<?php

class model_login extends CI_Model{
    
    public function login($username,$password){
        
        $this->db->select('aid');
        $this->db->from('t_admin');
        $this->db->where('admin_username',$username);
        $this->db->where('admin_password',$password);
       $query= $this->db->get();
        if($query->num_rows()==1){
            return 1;
           
        }
        else{
            return 0;
        }
            
    }

    public function getadmininfo($aid){
       $query= $this->db->query("SELECT * FROM t_admin where aid='$aid'");
       return $query;
    }
}