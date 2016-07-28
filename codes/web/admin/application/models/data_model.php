<?php

class data_model extends CI_Model {

    public function users_count() {
        $query = $this->db->query("select *  from t_entity where MONTH(t_entity.Create_Dt)=MONTH(NOW()) and YEAR(t_entity.Create_Dt)=YEAR(NOW()) and DAY(t_entity.Create_Dt)=DAY(NOW())");
        $count = $query->num_rows();

        return $count;
    }

    public function users_count_date($date) {
        $query = $this->db->query("select * from t_entity where date(Create_Dt)='$date'");
        $count = $query->num_rows();
        return $count;
    }

    public function new_male_users_count($date) {
        $query = $this->db->query("SELECT t_entity_details.First_Name,t_entity.Create_Dt FROM t_entity_details Inner join t_entity on t_entity.Entity_Id=t_entity_details.Entity_Id WHERE date(t_entity.Create_Dt)='$date' and t_entity_details.sex=1");
        $count = $query->num_rows();

        return $count;
    }

    public function new_female_users_count($date) {
        $query = $this->db->query("SELECT t_entity_details.First_Name,t_entity.Create_Dt FROM t_entity_details Inner join t_entity on t_entity.Entity_Id=t_entity_details.Entity_Id WHERE date(t_entity.Create_Dt)='$date' and t_entity_details.sex=2 ");
        $count = $query->num_rows();

        return $count;
    }

    public function chat_count() {
        $query = $this->db->query("select * from t_chatmessages");
        $count = $query->num_rows();
        return $count;
    }

    public function male_count_today() {
        $query = $this->db->query("SELECT t_entity_details.First_Name,t_entity.Create_Dt FROM t_entity_details Inner join t_entity on t_entity.Entity_Id=t_entity_details.Entity_Id WHERE t_entity_details.sex=1 and MONTH(t_entity.Create_Dt)=MONTH(NOW()) and YEAR(t_entity.Create_Dt)=YEAR(NOW()) and DAY(t_entity.Create_Dt)=DAY(NOW()) ");
        $count = $query->num_rows();

        return $count;
    }

    public function female_count_today() {
        $query = $this->db->query("SELECT t_entity_details.First_Name,t_entity.Create_Dt FROM t_entity_details Inner join t_entity on t_entity.Entity_Id=t_entity_details.Entity_Id WHERE t_entity_details.sex=2 and MONTH(t_entity.Create_Dt)=MONTH(NOW()) and YEAR(t_entity.Create_Dt)=YEAR(NOW()) and DAY(t_entity.Create_Dt)=DAY(NOW()) ");
        $count = $query->num_rows();

        return $count;
    }

    public function users_list() {
        $query = $this->db->query("SELECT * FROM (t_entity_details inner join t_entity on t_entity_details.entity_id=t_entity.entity_id)");
        return $query->result();
    }

    public function question_list() {
        $query = $this->db->query("SELECT * FROM t_details");
        return $query->result();
    }
     public function chekin_location() {
        $query = $this->db->query("SELECT * FROM t_location");
        return $query->result();
    }
     public function chekin_location_id($location_id) {
        $query = $this->db->query("SELECT * FROM t_location where id='$location_id'");
        return $query->result();
    }

    public function option_list($q_id) {
      
         $query = $this->db->query("SELECT t.id, t.d_id, t.detail_option,(SELECT details_ques FROM t_details WHERE d_id = t.d_id) AS question FROM t_details_ans t
WHERE d_id ='$q_id'");

       // $query = $this->db->query("SELECT * FROM t_details_ans where d_id='$q_id'");
        return $query->result();
    }

    public function question_edit($q_id) {
        $query = $this->db->query("SELECT * FROM t_details where d_id='$q_id'");
        return $query->result();
    }

    public function option_edit($q_id) {
        $query = $this->db->query("SELECT * FROM t_details_ans where id='$q_id'");
        return $query->result();
    }
    
     public function option_delete($q_id) {
        $query = $this->db->query("delete  FROM t_details_ans where id='$q_id'");
        return $query;
    }
     public function question_delete($q_id) {
        $query = $this->db->query("delete  FROM t_details where d_id='$q_id'");
        return $query;
    }
    
    
    

    public function question_update($quistion, $q_id) {
        $query = $this->db->query("update t_details set details_ques='$quistion'  where d_id='$q_id'");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function option_update($option_id, $optionlist) {
        $query = $this->db->query("update t_details_ans set detail_option='$optionlist'  where id='$option_id'");
        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }

    public function users_list_search($string) {
        $query = $this->db->query("SELECT * FROM (t_entity_details inner join t_entity on t_entity_details.entity_id=t_entity.entity_id) where t_entity_details.First_Name like '$string' or t_entity_details.Last_Name like '%$string%'");
        return $query->result();
    }

    public function addadmin($username, $password, $confirm) {
        if ($password == $confirm) {

            $query = $this->db->query("insert into t_admin (admin_username,admin_password) values('$username','$password')");

            if ($query) {
                return 1;
            } else {
                
            }
        } else {
            return 0;
        }
    }
       public function location_add($loc_name, $loc_lat, $loc_long,$address) {
        

            $query = $this->db->query("insert into t_location (Loc_name,Loc_lat,Loc_long,loc_address) values('$loc_name','$loc_lat','$loc_long','$address')");

            if ($query) {
                return 1;
            } else {
                return 0;
            }
                
            
       
    }
    
       public function location_update($chekin_id,$loc_name, $loc_lat, $loc_long,$address) {
        

            //$query = $this->db->query("insert into t_location (Loc_name,Loc_lat,Loc_long,loc_address) values('$loc_name','$loc_lat','$loc_long','$address')");

               $query = $this->db->query("update t_location set Loc_name='".$loc_name."',loc_address ='".$address."',Loc_lat='".$loc_lat."',Loc_long='".$loc_long."' where id='".$chekin_id."'");
            
            if ($query) {
                return 1;
            } else {
                return 0;
            }
                
            
       
    }
    
      
       public function location_delete($delete) {
        

            //$query = $this->db->query("insert into t_location (Loc_name,Loc_lat,Loc_long,loc_address) values('$loc_name','$loc_lat','$loc_long','$address')");

               $query = $this->db->query("delete from t_location where id='$delete'");
            if ($query) {
                return 1;
            } else {
                return 0;
            }
                
            
       
    }
    
    
    
    
    

    public function insert_option($q_id, $option) {


        $query = $this->db->query("insert into t_details_ans(d_id,detail_option) values('$q_id','$option')");

        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }
    
    
     public function insert_answer($question,$option) {
     
        

        $query = $this->db->query("insert into t_details(details_ques) values('$question')");
        $d_id=  mysql_insert_id();
      
        
        foreach ($option as $value)
            {
           
                if($value!='')
               $query = $this->db->query("insert into t_details_ans(d_id,detail_option) values('$d_id','$value')");

            }
       
        

        if ($query) {
            return 1;
        } else {
            return 0;
        }
    }
    
    

    public function delete_user($eid) {
        if ($eid == '') {
            redirect('users');
        } else if (is_array($eid)) {

            $id = implode(',', $eid);
        } else {
            $id = $eid;
        }

        $query_entity = $this->db->query("delete from t_entity where Entity_Id in($id)");
        $query_entity_detail = $this->db->query("delete from t_entity_details where Entity_Id in($id)");
        if ($query_entity && $query_entity_detail) {
            return 1;
        } else {
            return 0;
        }
    }

}
