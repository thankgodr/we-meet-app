<?php

require_once 'Models/API.php';
require_once 'Models/ConDB.php';
require_once 'Models/getErrorMsg.php';
require_once 'Models/ManageToken.php';
define("APP_TITLE","We Meet");

// $entityid = $this->_getEntityId($args['ent_user_fbid']);
class MyAPI extends API {

    protected $User;
    private $db;
    private $host = 'http://www.tempysplace.com/debugfiles/you-and-me/web/'; // Change this to  server loc
    private $ios_cert_path = './cert/youandme.pem';
    private $ios_cert_pwd = 'flamer';
    private $androidApiKey = 'AIzaSyA-kfMA74eVmInPbIMCsBKpevmsnFKsYKo';
    private $androidUrl = 'http://android.googleapis.com/gcm/send';
    private $chatMessagePageSize = 30;
    /*
      Development -- ssl://gateway.sandbox.push.apple.com:2195
      Production -- ssl://gateway.push.apple.com:2195
     */
    private $ios_cert_server = "ssl://gateway.push.apple.com:2195";

    public function __construct($request_uri, $postData, $origin) {

        parent::__construct($request_uri, $postData);

        $this->db = new ConDB();
// Abstracted out for example
//        $APIKey = new Models/APIKey();
//        $User = new Models/User();
//
//        if (!array_key_exists('apiKey', $this->request)) {
//            throw new Exception('No API Key provided');
//        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
//            throw new Exception('Invalid API Key');
//        } else if (array_key_exists('token', $this->request) &&
//                !$User->get('token', $this->request['token']))
//            throw new Exception('Invalid User Token');
//
//        $this->User = $User;
    }

    /*              ----------------                SERVICE METHODS             ---------------------               */
    /*
     * Method name: login
     * Desc: Login / Sign up for the app
     * Input: Request data
     * Output:  Success flag with data array if completed successfully, else data array with error flag
     * param :ent_first_name,ent_last_name,ent_fbid,ent_sex,ent_curr_lat,ent_curr_long,ent_dob,ent_push_token,ent_profile_pic,ent_device_type,ent_auth_type
     */

// 

    protected function login($args) {
//$args['ent_email'] || $args['ent_qbid'] == '' 
        if ($args['ent_first_name'] == '' || $args['ent_sex'] == '' || $args['ent_device_type'] == '' || $args['ent_push_token'] == '')
            return $this->_getStatusMessage(1, 1);

//        echo '2';
//        if ($this->_verifyEmail($args['ent_email'])) {
//
//            $msg = new getErrorMsg(1);
//            return array('errNum' => $msg->errId, 'errFlag' => $msg->errFlag, 'errMsg' => $msg->errMsg);
//        }

        $token_obj = new ManageToken();
        $args['ent_auth_type'] = '1';
        if ($args['ent_auth_type'] == '1') {

            if ($args['ent_fbid'] == '')
                return $this->_getStatusMessage(1, 2);

            return $this->_entitySocialLogin($args, $args['ent_fbid'], $token_obj);
        }
        else if ($args['ent_auth_type'] == '2') {

            if ($args['ent_gp_id'] == '')
                return $this->_getStatusMessage(1, 3);

            return $this->_entitySocialLogin($args, $args['ent_gp_id'], $token_obj);
        }
        else {
            return $this->_getStatusMessage(8, 4);
        }
    }

   protected function update_profile_pic($args, $entity_id) {

        if ($args['ent_user_fbid'] == ''|| $args['ent_new_prf_index_id'] == ''|| $args['ent_new_image_id']=='')
             return $this->_getStatusMessage(1, 58);
           
            
            
            $new=$args['ent_new_prf_index_id'];
            $new_image=$args['ent_new_image_id'];
            
            
            

         $entityid = $this->_getEntityId($args['ent_user_fbid']);
        
        
        
        //set profile image new =0 and imgae id for profile iamge 
         $getoldprofile = "select * from t_images where entity_id='" . $entityid . "' and index_id= '0' ";
         $data =  mysql_query($getoldprofile);
         
         $oldprofile=  mysql_fetch_assoc($data);
         
          $old_id=$oldprofile['image_id'];
          
        
        
          $updatenew="update t_images set index_id='0' where  image_id='$new_image'"; 
          
           $geturl= "select * from t_images where entity_id='" . $entityid . "' and image_id='$new_image' ";
         $geturl =  mysql_query($geturl);
         
         $image=  mysql_fetch_assoc($geturl);
         
          $profileimageurl = $image['image_url'];
          
          $updateAdditionalDetailsQry = "
                 update t_entity_details
                        set                        
                        Profile_Pic_Url='" . $profileimageurl . "'
                        where
                        Entity_Id = '" . $entityid . "'";
          
          
          
          
        
        //set profile image_id = old image id 
        
         $updateold ="update t_images set index_id='$new' where  image_id='$old_id'"; 
        
        
      mysql_query($updatenew, $this->db->conn);
     $affect= mysql_query($updateold, $this->db->conn);
   
        
        
       $profileimage = mysql_query($updateAdditionalDetailsQry, $this->db->conn);
       
       
       $getdetail = "select * from t_images where entity_id='" . $entityid . "'";

        $getdetails = mysql_query($getdetail, $this->db->conn);

        $likesArr = array();

        if (mysql_num_rows($getdetails) > 0) {

            $errMsgArr = $this->_getStatusMessage(65, 30);

            while ($detail = mysql_fetch_assoc($getdetails)) {



                $likesArr[] = array("image_id" => $detail['image_id'], "image_url" => $detail['image_url'], "index_id" => $detail['index_id']);
            }


            //$likesArr[] = array('id' => $qustionRow['que_id'], 'quetion' => $qustionRow['quetion'], 'option_a' => $qustionRow['option_a'], 'option_b' => $qustionRow['option_b'], 'option_c' => $qustionRow['option_c'], 'option_d' => $qustionRow['option_d'], 'your_ans' => $objtrueans, 'pref_a' => $prefa, 'pref_b' => $prefb, 'pref_c' => $prefc, 'pref_d' => $prefd); //, 'age' => $likeRow['age']
        } else {

            $errMsgArr = $this->_getStatusMessage(51, 31);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'Userphotos' => $likesArr);
        
    
    
    }

 /*
     * Method name: update_status
     * Desc: Updates user status for the app
     * Input: Request data
     * Output:  status message according to the result
     * param:ent_status,ent_user_fbid
     */
     protected function update_status($args) {

        if ($args['ent_status'] == '' && $args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 204);
        $status=$args['ent_status'] ;
       $entityId = $this->_getEntityId($args['ent_user_fbid']);
       
        $updateImageQry = "update t_entity_details set Status='$status' where entity_id='$entityId'";
           $updateOrInsertRes = mysql_query($updateImageQry, $this->db->conn);
            $affected_rows = mysql_affected_rows($updateOrInsertRes); 
            
           // echo $affected_rows;

            if (mysql_affected_rows() >0) {
                $errMsgArr = $this->_getStatusMessage(67, 12);
            } else {
                if(!$updateOrInsertRes)
                {
                    $errMsgArr = $this->_getStatusMessage(12, 15);
                }
                else{
                 $errMsgArr = $this->_getStatusMessage(68, 15);
                }
            }
        
       


        return array( 'errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'],'status'=>$args['ent_status']);
    }
    

    /*
     * Method name: updatePreferences
     * Desc: Updates user preferences for the app
     * Input: Request data
     * Output:  status message according to the result
     * param:ent_sex,ent_pref_sex,ent_pref_lower_age,ent_pref_upper_age,ent_pref_radius
     */

    protected function updatePreferences($args) {

        if ($args['ent_sex'] == '' || $args['ent_pref_sex'] == '' || $args['ent_pref_lower_age'] == '' || $args['ent_pref_upper_age'] == '' || $args['ent_pref_radius'] == '')
            return $this->_getStatusMessage(1, 5);

        $entityid = $this->_getEntityId($args['ent_user_fbid']);

        $updatePrefQry = "
                    update t_preferences 
                    set 
                    Preference_Sex = '" . $args['ent_pref_sex'] . "',
                    Preference_lower_age = '" . $args['ent_pref_lower_age'] . "',
                    Preference_upper_age = '" . $args['ent_pref_upper_age'] . "',
                    Preference_radius = '" . $args['ent_pref_radius'] . "'
                       
                    where
                    Entity_Id = '" . $entityid . "'";

        $updatePrefRes = mysql_query($updatePrefQry, $this->db->conn);

        if (mysql_affected_rows() > 0) {

            $updateSexQry = "update t_entity_details set Sex = '" . $args['ent_sex'] . "' where Entity_Id = '" . $entityid . "'";
            mysql_query($updateSexQry, $this->db->conn);

            return $this->_getStatusMessage(13, 6);
        } else {
            $inserted_id = 1;
            $checkPrefQry = "select Entity_Id from t_preferences where Entity_Id = '" . $entityid . "'";
            $checkPrefRes = mysql_query($checkPrefQry, $this->db->conn);
            if (mysql_num_rows($checkPrefRes) <= 0) {
                $insertPreferencesQry = "insert into t_preferences(Entity_Id,Preference_Sex,Preference_lower_age,Preference_upper_age,Preference_radius) values('" . $entityid . "','" . $args['ent_sex'] . "','" . $args['ent_pref_lower_age'] . "','" . $args['ent_pref_upper_age'] . "','" . $args['ent_pref_radius'] . "')";
                mysql_query($insertPreferencesQry, $this->db->conn);
                $inserted_id = mysql_insert_id();
            }
            if ($updatePrefRes && $inserted_id > 0)
                return $this->_getStatusMessage(14, 7);
            else
                return $this->_getStatusMessage(15, 8);
        }
    }
    

    /*
     * Method name: get_quetion
     * Desc: get list of all question  call ws from  starting app 
     * Input: Request data
     * Output:  image name if uploaded and status message according to the result
     * pararm :ent_user_fbid;
     */

    protected function get_quetion($args) {

        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 200);



        $entityId = $this->_getEntityId($args['ent_user_fbid']);

        $getdetail = "select * from t_details";

        $getdetails = mysql_query($getdetail, $this->db->conn);

        $likesArr = array();

        if (mysql_num_rows($getdetails) > 0) {

            $errMsgArr = $this->_getStatusMessage(61, 30);

            while ($detail = mysql_fetch_assoc($getdetails)) {
                $did = $detail['d_id'];
                $option = "select * from t_details_ans where  d_id = '" . $did . "'";
                $objtrueans = "";
                $answer = '';
                $optiondetail = array();
                $option_detail = mysql_query($option, $this->db->conn);

                while ($ans = mysql_fetch_assoc($option_detail)) {
                    if ($detail['d_id'] == $ans['d_id']) {

                        $flag = 0;
                        $did = $ans['d_id'];
                        $trueans = "select * from t_detail_user_ans where Entity_Id = '" . $entityId . "' AND d_id = '" . $did . "'";
                        $objtrueans = "";


                        $trueans1 = mysql_query($trueans, $this->db->conn);

                        while ($ans1 = mysql_fetch_assoc($trueans1)) {


                            $objtrueans = $ans1['user_ans'];



                            if ($ans['id'] == $objtrueans) {
                                $flag = '1';
                            }
                        }

                        $detail1['ans_id'] = $ans['id'];
                        $detail1['q_id'] = $ans['d_id'];
                        $detail1['option'] = $ans['detail_option'];
                        $detail1['flag'] = $flag;


                        array_push($optiondetail, $detail1);
                    }
                }



                $likesArr[] = array("q_id" => $detail['d_id'], "question" => $detail['details_ques'], "options" => $optiondetail);
            }

            //$likesArr[] = array('id' => $qustionRow['que_id'], 'quetion' => $qustionRow['quetion'], 'option_a' => $qustionRow['option_a'], 'option_b' => $qustionRow['option_b'], 'option_c' => $qustionRow['option_c'], 'option_d' => $qustionRow['option_d'], 'your_ans' => $objtrueans, 'pref_a' => $prefa, 'pref_b' => $prefb, 'pref_c' => $prefc, 'pref_d' => $prefd); //, 'age' => $likeRow['age']
        } else {

            $errMsgArr = $this->_getStatusMessage(51, 31);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'detail_que' => $likesArr);
    }

    /*
     * Method name: get_question_ans_insert
     * Desc: user can answer for any question insert question id
     * Input: Request data
     * Output:  image name if uploaded and status message according to the result
     * ent_json formatae[{"q_id":1,"ans_id",2},{"q_id":1,"ans_id",2}]
     * pararm :ent_json,ent_user_fbid;

     */

    protected function get_question_ans_insert($args) {

        if ($args['ent_json'] == '' || $args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 204);
        $entityId = $this->_getEntityId($args['ent_user_fbid']);


        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */

        $json = stripslashes($args['ent_json']);

        $data = json_decode($json);

        foreach ($data as $value) {
            $q_id = $value->q_id;
            $ans_id = $value->ans_id;

            $check = "select * from t_detail_user_ans where Entity_Id='" . $entityId . "' And d_id ='" . $q_id . "'";

            $checkquery = mysql_query($check, $this->db->conn);
            $no_row = mysql_num_rows($checkquery);

            if ($no_row >= 1) {
                $insertans = "update t_detail_user_ans SET
                    
                    user_ans ='" . $ans_id . "'
                   
                        
                    where Entity_Id='" . $entityId . "' and d_id='" . $q_id . "'";

                $getquestion = mysql_query($insertans, $this->db->conn);
            } else {
                $insertans = "insert into t_detail_user_ans(Entity_Id,d_id,user_ans)values('" . $entityId . "','" . $q_id . "','" . $ans_id . "')";

                $getquestion = mysql_query($insertans, $this->db->conn);
            }
        }
        if (mysql_affected_rows() > 0) {

            $errMsgArr = $this->_getStatusMessage(62, 30);
        } else {

            $errMsgArr = $this->_getStatusMessage(63, 31);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg']);
    }
    
  
    /* SYNC MESSAGE HISTORY TO DEVICE 
     * get chat history from last chat id available in device
     * input :same as get chat history service
     * output : chat last messages
     */

    protected function getChatSync($args) {
        $last_id= $args['ent_last_mess_id'];
        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 52);

         $entityId = $this->_getEntityId($args['ent_user_fbid']);
         
        $recieverId = $this->_getEntityId($args['ent_recever_user_fbid']);

        if (is_array($recieverId))
            return $recieverId;

        if ($args['ent_chat_page'] == '')
            $pageNum = 1;
        else
            $pageNum = (int) $args['ent_chat_page'];

        $lowerLimit = ($this->chatMessagePageSize * $pageNum) - $this->chatMessagePageSize;
        $upperLimit = $this->chatMessagePageSize * $pageNum;

        $msgArr = array();

        $getHistoryQry = "select sender,mid,message,msg_dt,(select Fb_Id from t_entity_details where Entity_Id = sender) as sender_fb_Id,(select First_Name from t_entity_details where Entity_Id = sender) as sender_name,(select Fb_Id from t_entity_details where Entity_Id = receiver) as reciever_fb_Id 
            from t_chatmessages 
            where mid > '$last_id' AND
            (
            (sender = '" . $entityId . "' and receiver = '" . $recieverId . "') 
                or 
            (sender = '" . $recieverId . "' and receiver = '" . $entityId. "') AND  user1!='" . $entityId . "' 
            )";
        $getHistoryRes = mysql_query($getHistoryQry, $this->db->conn);

        if (mysql_num_rows($getHistoryRes) > 0) {

            $errMsgArr = $this->_getStatusMessage(47, 53);

            while ($msg = mysql_fetch_assoc($getHistoryRes)) {
                $msgArr[] = array('mid' => $msg['mid'], 'sname' => $msg['sender_name'], 'rfid' => $msg['reciever_fb_Id'], 'sfid' => $msg['sender_fb_Id'], 'msg' => $msg['message'], 'dt' => $msg['msg_dt']);
            }
        } else {
            $errMsgArr = $this->_getStatusMessage(48, 54);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'chat' => $msgArr);
    }

  /* image upload*/
  /*
       protected function upload_user_image($args) {

        if ($args['ent_userimage'] == ''  && $args['ent_user_fbid'] == ''  && $args['ent_index_id'] == '')
            return $this->_getStatusMessage(1, 204);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);
          if (is_array($returned))
          return $returned; */
/*
        $entityId = $this->_getEntityId($args['ent_user_fbid']);
 $timestamp=date('Y-m-d H:i:s');
$milliseconds = 1000 * strtotime($timestamp);

        $profImageFlag = 0;
        if ($milliseconds != '') {

            $profImageName = $milliseconds.".jpg";
            

            $file_to_open = 'pics/' . $profImageName;

            $profPicRes = 10;

            if (!file_exists($file_to_open)) {

                $base = $args['ent_userimage'];
                $binary = base64_decode($base);
                //header('Content-Type: bitmap; charset=utf-8');

                $file = fopen('' . $file_to_open . '', 'wb');
                $profPicRes = fwrite($file, $binary);
                fclose($file);
            }
            
            

            $prof_image_url = $this->host . 'pics/' . $profImageName;

            if ($profPicRes !== FALSE) {

                $affected_rows = 0;
               

                    $checkImageQry = "select image_id from t_images where entity_id = '" . $entityId . "' and image_url= '" . $other_image_url . "'";
                    $checkImageRes = mysql_query($checkImageQry, $this->db->conn);

                    if (!mysql_num_rows($checkImageRes) > 0) {
                        $insertImageQry = "insert into t_images(entity_id,image_url,index_id) values('" . $entityId . "','" . $prof_image_url . "','".$args['ent_index_id']."')";
                        $updateOrInsertRes = mysql_query($insertImageQry, $this->db->conn);
                        $affected_rows = mysql_insert_id();
                    } else {
                        // image url already inserted.
                    }
                

                if ($affected_rows > 0) {
                    $errMsgArr = $this->_getStatusMessage(18, 12);
                } else {
                    if ($updateOrInsertRes)
                        $errMsgArr = $this->_getStatusMessage(12, 15);
                    else
                        $errMsgArr = $this->_getStatusMessage(11, 16);
                }
            }
            else {
                $errMsgArr = $this->_getStatusMessage(17, 15);
            }
        } else {
            return $this->_getStatusMessage(16, 20);
        }

        return array('picURL' => $prof_image_url, 'errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'],'ent_image_id'=>"".$affected_rows);
    }
    */
    
     protected function upload_user_image($args) {

        if ($args['ent_userimage'] == '' && $args['ent_user_fbid'] == '' && $args['ent_index_id'] == '')
            return $this->_getStatusMessage(1, 204);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);
          if (is_array($returned))
          return $returned; */

        $entityId = $this->_getEntityId($args['ent_user_fbid']);
        $timestamp = date('Y-m-d H:i:s');
        $milliseconds = 1000 * strtotime($timestamp);

        $profImageFlag = 0;

  
        $profImageName = 'profile_photo'.$milliseconds . ".jpg";


        $file_to_open = 'pics/' . $profImageName;

        $profPicRes = 10;

        if (!file_exists($file_to_open)) {

            $base = $args['ent_userimage'];
            $binary = base64_decode($base);
            //header('Content-Type: bitmap; charset=utf-8');

            $file = fopen('' . $file_to_open . '', 'wb');
            $profPicRes = fwrite($file, $binary);
            fclose($file);
        }



        $prof_image_url = $this->host . 'pics/' . $profImageName;

        if ($profPicRes !== FALSE) {

            $affected_rows = 0;


            $checkImageQry = "select image_id from t_images where entity_id = '" . $entityId . "' and index_id= '" . $args['ent_index_id'] . "'";
            $checkImageRes = mysql_query($checkImageQry, $this->db->conn);
	$id = mysql_fetch_assoc($checkImageRes);
            $imageid=$id['image_id'];
            
            if (!mysql_num_rows($checkImageRes) > 0) {
                $insertImageQry = "insert into t_images(entity_id,image_url,index_id) values('" . $entityId . "','" . $prof_image_url . "','" . $args['ent_index_id'] . "')";
                $updateOrInsertRes = mysql_query($insertImageQry, $this->db->conn);
                $affected_rows = mysql_insert_id();
            } else {
                
                 $updateImageQry = "update t_images set image_url='$prof_image_url' where entity_id='$entityId' and index_id= '" . $args['ent_index_id'] . "'";
                $updateOrInsertRes = mysql_query($updateImageQry, $this->db->conn);
               $affected_rows = $imageid; 
            }


            if ($affected_rows > 0) {
                $errMsgArr = $this->_getStatusMessage(18, 12);
            } else {
                if ($updateOrInsertRes)
                    $errMsgArr = $this->_getStatusMessage(12, 15);
                else
                    $errMsgArr = $this->_getStatusMessage(11, 16);
            }
        }
        else {
            $errMsgArr = $this->_getStatusMessage(17, 15);
        }


        return array('picURL' => $prof_image_url, 'errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'],'ent_image_id'=>"".$affected_rows);
    }
    
   /*
     * Method name: delete_user_Image
     * Desc: delete user image database as well as pics folder
     * Input: Request data
     * Output:  sucess or fail
     * param:ent_image_id,ent_user_fbid;
     * 
     */
    
    
    protected function delete_user_Image($args) {

        if ($args['ent_image_id'] == '')
            return $this->_getStatusMessage(1, 13);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */


        $entityId = $this->_getEntityId($args['ent_user_fbid']);
        
   
          $checkImageQry = "select image_url from t_images where entity_id = '" . $entityId . "' and image_id= '" . $args['ent_image_id']. "'";
                    $checkImageRes = mysql_query($checkImageQry, $this->db->conn);
                    $name=  mysql_fetch_assoc($checkImageRes);
                     $name['image_url']; 
        $imageurl = explode('/', $name['image_url']);
     // print_r($imageurl);
           
        $other_image_url = $this->host . 'pics/' . $args['ent_image_name'];
        
        $imagename="pics/". $imageurl[5];
        
            @unlink($imagename);
            
            
            
            $deleteImageQry = "delete from t_images where entity_id = '" . $entityId . "' and image_id = '" . $args['ent_image_id']. "'";
            $updateOrDeleteRes = mysql_query($deleteImageQry, $this->db->conn);
            $affected_rows = mysql_affected_rows();
        

        if ($affected_rows > 0) {
            $errMsgArr = $this->_getStatusMessage(23, 14);
        } else {

            if ($updateOrDeleteRes)
                $errMsgArr = $this->_getStatusMessage(24, 15);
            else
                $errMsgArr = $this->_getStatusMessage(25, 16);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg']);
    }
    
    /*
     * Method name: get_user_profile_pic
     * Desc: get user profile uploded photos 
     * Input: Request data
     * Output:  image if availabe array return
     * param:ent_user_fbid;
     * 
     */
    
    protected function get_user_profile_pic($args) {

        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 200);



        $entityId = $this->_getEntityId($args['ent_user_fbid']);

         $getdetail = "select * from t_images where entity_id='".$entityId."'";

         $getdetails = mysql_query($getdetail, $this->db->conn);

        $likesArr = array();

        if (mysql_num_rows($getdetails) > 0) {

            $errMsgArr = $this->_getStatusMessage(65, 30);

            while ($detail = mysql_fetch_assoc($getdetails)) {
                
               

                $likesArr[] = array("image_id" => $detail['image_id'], "image_url" => $detail['image_url'], "index_id" => $detail['index_id']);
            }
            

            //$likesArr[] = array('id' => $qustionRow['que_id'], 'quetion' => $qustionRow['quetion'], 'option_a' => $qustionRow['option_a'], 'option_b' => $qustionRow['option_b'], 'option_c' => $qustionRow['option_c'], 'option_d' => $qustionRow['option_d'], 'your_ans' => $objtrueans, 'pref_a' => $prefa, 'pref_b' => $prefb, 'pref_c' => $prefc, 'pref_d' => $prefd); //, 'age' => $likeRow['age']
        } else {

            $errMsgArr = $this->_getStatusMessage(66, 31);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'Userphotos' => $likesArr);
    }
    
  
  
    
    
    /*
     * Method name: get_question_ans_insert_optinal
     * Desc: user can answer for any question insert question id with prefered other user in them option id
     * Input: Request data
     * Output:  image name if uploaded and status message according to the result
     * ent_json formatae[{"q_id":1,"ans_id",2,"them":"1,2,4"},{"q_id":1,"ans_id",2,"them":"78,85,84"}]
     * pararm :ent_json,ent_user_fbid;

     */
    
     protected function get_question_ans_insert_optional($args) {

        if ($args['ent_json'] == '' || $args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 204);
        $entityId = $this->_getEntityId($args['ent_user_fbid']);
        // $json = stripslashes($args['ent_json']);
        $json = $args['ent_json'];
        $data = json_decode($json);
        foreach ($data as $value) {
            $q_id = $value->q_id;
            $ans_id = $value->ans_id;
            $them = $value->them;
            $check = "select * from t_detail_user_ans where Entity_Id='" . $entityId . "' And d_id ='" . $q_id . "'";
            $checkquery = mysql_query($check, $this->db->conn);
            $no_row = mysql_num_rows($checkquery);
            if ($no_row >= 1) {
                $insertans = "update t_detail_user_ans SET
            
                    user_ans ='" . $ans_id . "',them='".$them."'
                   
                        
                    where Entity_Id='" . $entityId . "' and d_id='" . $q_id . "'";

                $getquestion = mysql_query($insertans, $this->db->conn);
            } else {
                $insertans = "insert into t_detail_user_ans(Entity_Id,d_id,user_ans,them)values('" . $entityId . "','" . $q_id . "','" . $ans_id . "','" . $them . "')";

                $getquestion = mysql_query($insertans, $this->db->conn);
            }
        }
        if (mysql_affected_rows() > 0) {

            $errMsgArr = $this->_getStatusMessage(62, 30);
        } else {

            $errMsgArr = $this->_getStatusMessage(63, 31);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg']);
    }

    
    
    /*
     * Method name: uploadChunk
     * Desc: upload image in base64 
     * Input: Request data
     * pararm :ent_image_chunk,ent_image_name,ent_image_flag 
     * extra :this ws not for use
     */

    protected function uploadChunk($args) {

        if ($args['ent_image_chunk'] == '' && $args['ent_image_name'] == '' && $args['ent_image_flag'] == '')
            return $this->_getStatusMessage(1, 204);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);
          if (is_array($returned))
          return $returned; */

        $entityId = $this->_getEntityId($args['ent_user_fbid']);


        $profImageFlag = 0;
        if ($args['ent_image_name'] != '') {

            $profImageName = $args['ent_image_name'];

            $file_to_open = 'pics/' . $profImageName;

            $profPicRes = 10;

            if (!file_exists($file_to_open)) {

                $base = $args['ent_image_chunk'];
                $binary = base64_decode($base);
                header('Content-Type: bitmap; charset=utf-8');

                $file = fopen('' . $file_to_open . '', 'wb');
                $profPicRes = fwrite($file, $binary);
                fclose($file);
            }

            $prof_image_url = $this->host . 'pics/' . $profImageName;

            if ($profPicRes !== FALSE) {

                $affected_rows = 0;
                if ($args['ent_image_flag'] == '1') {

                    $updateProfilePicQry = "update t_entity_details set Profile_Pic_Url = '" . $prof_image_url . "' where Entity_Id = '" . $entityId . "'";
                    $updateOrInsertRes = mysql_query($updateProfilePicQry, $this->db->conn);
                    $affected_rows = mysql_affected_rows();
                } else {

                    $checkImageQry = "select image_id from t_images where entity_id = '" . $entityId . "' and image_url= '" . $other_image_url . "'";
                    $checkImageRes = mysql_query($checkImageQry, $this->db->conn);

                    if (!mysql_num_rows($checkImageRes) > 0) {
                        $insertImageQry = "insert into t_images(entity_id,image_url) values('" . $entityId . "','" . $prof_image_url . "')";
                        $updateOrInsertRes = mysql_query($insertImageQry, $this->db->conn);
                        $affected_rows = mysql_insert_id();
                    } else {
                        // image url already inserted.
                    }
                }

                if ($affected_rows > 0) {
                    $errMsgArr = $this->_getStatusMessage(18, 12);
                } else {
                    if ($updateOrInsertRes)
                        $errMsgArr = $this->_getStatusMessage(12, 15);
                    else
                        $errMsgArr = $this->_getStatusMessage(11, 16);
                }
            }
            else {
                $errMsgArr = $this->_getStatusMessage(17, 15);
            }
        } else {
            return $this->_getStatusMessage(16, 20);
        }

        return array('picURL' => $prof_image_url, 'errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg']);
    }

    /*
     * Method name: uploadImage
     * Desc: Uploads media to the server folder named "pics"
     * Input: Request data
     * Output:  image name if uploaded and status message according to the result
     * param:ent_prof_url,ent_other_urls;
     * param:ent_prof_url,ent_other_urls,ent_user_fbid
     */

    protected function uploadImage($args) {

        if ($args['ent_prof_url'] == '' && $args['ent_other_urls'] == '')
            return $this->_getStatusMessage(1, 204);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */


        $entityId = $this->_getEntityId($args['ent_user_fbid']);

        $profImageFlag = 0;
        if ($args['ent_prof_url'] != '') {

            $method_arg = explode('/', $args['ent_prof_url']);
            $profImageName = end($method_arg);

            $file_to_open = 'pics/' . $profImageName;

            $profPicRes = 10;

            if (!file_exists($file_to_open)) {

                $profPicRes = file_put_contents($file_to_open, file_get_contents($args['ent_prof_url']));
            }

            $prof_image_url = $this->host . 'pics/' . $profImageName;

            if ($profPicRes !== FALSE) {

                $updateProfilePicQry = "update t_entity_details set Profile_Pic_Url = '" . $prof_image_url . "' where Entity_Id = '" . $entityId . "'";
                $updateProfilePicRes = mysql_query($updateProfilePicQry, $this->db->conn);

                if (mysql_affected_rows() > 0)
                    $profImageFlag = 1;
                else if ($updateProfilePicRes)
                    $profImageFlag = 1;
            }
        }
        if ($args['ent_other_urls'] !== '') {

            $otherPicsArr = array_filter(array_unique(explode(',', $args['ent_other_urls'])));

            $otherPicsResArr = array();

            foreach ($otherPicsArr as $otherPic) {

                $method_arg = explode('/', $otherPic);
                $otherImageName = end($method_arg);

                $file_to_open = 'pics/' . $otherImageName;

                $otherPicRes = 10;

                if (!file_exists($file_to_open)) {

                    $otherPicRes = file_put_contents($file_to_open, file_get_contents($otherPic));
                }

                $other_image_url = $this->host . 'pics/' . $otherImageName;

                $otherPicFlag = 0;

                if ($otherPicRes !== FALSE) {

                    $checkImageQry = "select image_id from t_images where entity_id = '" . $entityId . "' and image_url= '" . $other_image_url . "'";
                    $checkImageRes = mysql_query($checkImageQry, $this->db->conn);

                    if (!mysql_num_rows($checkImageRes) > 0) {
                        $insertImageQry = "insert into t_images(entity_id,image_url) values('" . $entityId . "','" . $other_image_url . "')";
                        mysql_query($insertImageQry, $this->db->conn);
                        if (mysql_insert_id() > 0)
                            $otherPicFlag = 1;
                    } else {
                        $otherPicFlag = 1;
                    }
                }

                $otherPicsResArr[] = array('url' => $other_image_url, 'flag' => $otherPicFlag);
            }
        }

        $errMsgArr = $this->_getStatusMessage(18, 12);

        return array('picURL' => $prof_image_url, 'profFlag' => $profImageFlag, 'errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'images' => $otherPicsResArr);
    }

    /*
     * Method name: deleteImage
     * Desc: Delete media from the server folder named "pics"
     * Input: Request data
     * Output:  Success or error message
     * param:ent_image_name,ent_image_flag,ent_user_fbid
     */

    protected function deleteImage($args) {

        if ($args['ent_image_name'] == '' || $args['ent_image_flag'] == '')
            return $this->_getStatusMessage(1, 13);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */


        $entityId = $this->_getEntityId($args['ent_user_fbid']);

        $affected_rows = 0;
        if ($args['ent_image_flag'] == '1') {

            $updateProfilePicQry = "update t_entity_details set Profile_Pic_Url = '' where Entity_Id = '" . $entityId . "'";
            $updateOrDeleteRes = mysql_query($updateProfilePicQry, $this->db->conn);
            $affected_rows = mysql_affected_rows();
            $other_image_url = $this->host . 'pics/' . $args['ent_image_name'];
            unlink($args['ent_image_name']);
        } else {

            $deleteImageQry = "delete from t_images where entity_id = '" . $entityId . "' and image_url = '" . $args['ent_image_name'] . "'";
            $updateOrDeleteRes = mysql_query($deleteImageQry, $this->db->conn);
            $affected_rows = mysql_affected_rows();
        }

        if ($affected_rows > 0) {
            $errMsgArr = $this->_getStatusMessage(23, 14);
        } else {

            if ($updateOrDeleteRes)
                $errMsgArr = $this->_getStatusMessage(24, 15);
            else
                $errMsgArr = $this->_getStatusMessage(25, 16);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg']);
    }

    
    
    
    /*
     * Method name: findMatches
     * Desc: Finds matches according to the user preferences
     * Input: Request data
     * Output:  Matched users details if available, else returns error message
     * param:ent_user_fbid
     */

    protected function findMatches($args) {

        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 13);


        /*  $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */


        $entityId = $this->_getEntityId($args['ent_user_fbid']);
        // working query
        $getUserPrefQry = "select 
            p.Preference_Sex,p.Preference_lower_age,p.Preference_upper_age,p.Preference_radius,ed.Current_Lat,ed.Current_Long,ed.dob
            from t_preferences p, t_entity_details ed 
            where 
            ed.Entity_Id = p.Entity_Id and
            ed.Entity_Id = '" . $entityId . "'";

        /* original : errored
          $getUserPrefQry = "select
          p.Preference_Sex,p.Preference_lower_age,p.Preference_upper_age,p.Preference_upper_age,p.Preference_radius,ed.Current_Lat,ed.Current_Long,ed.dob
          from t_preferences p, t_entity_details ed
          where
          ed.Entity_Id = p.Entity_Id and
          ed.Entity_Id = '" . $this->User['entityId'] . "'";
         */

        $getUserPrefRes = mysql_query($getUserPrefQry, $this->db->conn);



        $prefRow = mysql_fetch_assoc($getUserPrefRes);




//        print_r($prefRow);
        if ($prefRow['Preference_Sex'] == '3')
            $pref_sex_str = "ed.Sex = '1' or ed.Sex = '2'";
        else
            $pref_sex_str = "ed.Sex = '" . $prefRow['Preference_Sex'] . "'";


        if ($prefRow['Preference_lower_age'] == 0 && $prefRow['Preference_upper_age'] == 0)
            return $this->_getStatusMessage(19, 17);

        /* $getMatchesQry = "
          select ed.Entity_Id as entId,ed.First_Name,ed.Current_Lat,ed.Current_Long,ed.Profile_Pic_Url,ed.Sex,ed.Personal_Desc,ed.Fb_Id,ent.Last_Active_Dt_Time,
          YEAR(NOW()) - YEAR(ed.dob) - (RIGHT(NOW(), 5) < RIGHT(ed.DOB, 5)) as age
          from t_entity_details ed,t_entity ent
          where
          ed.Entity_Id = ent.Entity_Id and
          ent.status = 1 "; */


        // working query
         $getMatchesQry = "
            select ed.Entity_Id as entId,ed.Status as status,ed.First_Name,ed.Profile_Pic_Url,ed.Sex,ed.Current_Lat,ed.Current_Long,ed.Personal_Desc,ed.Fb_Id,ent.Last_Active_Dt_Time,
          YEAR(NOW()) - YEAR(ed.dob) - (RIGHT(NOW(), 5) < RIGHT(ed.DOB, 5)) as age
            from t_entity_details ed,t_entity ent 
            where 
            ed.Entity_Id = ent.Entity_Id and
            ent.status = 1 and
            ed.Entity_Id NOT IN (select Entity2_Id from t_likes where Entity1_Id = '" . $entityId . "' and (Like_Flag = '1' OR  Like_Flag = '2' OR  Like_Flag = '3')) 			
			and
            (3959 * acos( cos( radians('" . $prefRow['Current_Lat'] . "') ) * cos( radians(ed.Current_Lat) ) * cos( radians(ed.Current_Long) - radians('" . $prefRow['Current_Long'] . "') ) + sin( radians('" . $prefRow['Current_Lat'] . "') ) * sin( radians(ed.Current_Lat) ) ) ) <= " . $prefRow['Preference_radius'] . " 			
			and
            (" . $pref_sex_str . ") 			
            having 
            age BETWEEN '" . $prefRow['Preference_lower_age'] . "' AND '" . $prefRow['Preference_upper_age'] . "'";


        $getMatchesRes = mysql_query($getMatchesQry, $this->db->conn);




        if (mysql_num_rows($getMatchesRes) > 1) {

            $errMsgArr = $this->_getStatusMessage(20, 18);

            $marchedUsersArr = array();

            while ($match = mysql_fetch_assoc($getMatchesRes)) {
                $ent = $match['entId'];
                $matchperc = '';
                $getUserans = "select * from t_detail_user_ans where Entity_Id = '" . $entityId . "'";

                $getUseranspref = mysql_query($getUserans, $this->db->conn);
                $totalanswe = mysql_num_rows($getUseranspref);
                while ($data = mysql_fetch_array($getUseranspref)) {
                    $matchuser = "select * from t_detail_user_ans where Entity_Id = '" . $ent . "'  AND  d_id='" . $data['d_id'] . "'";
                    $matchuserquery = mysql_query($matchuser, $this->db->conn);
                    while ($data1 = mysql_fetch_array($matchuserquery)) {


                        if ($data1['user_ans'] == $data['user_ans']) {
                            $matchperc = $matchperc + 1;
                        }
                    }
                }


                $percentage = 100 * $matchperc / $totalanswe;
               // $percentage = sprintf("%.2f", $percentage);
$percentage = ceil($percentage);

                if ($percentage == false) {
                    $percentage = '0';
                }

                $mutuallike = "SELECT DISTINCT like_id FROM  `t_add_likes`  WHERE entity_id IN (  '" . $entityId . "','" . $ent . "' ) 
AND like_id IN ( SELECT ul2.like_id FROM t_add_likes ul1, t_add_likes ul2 WHERE ul1.like_id = ul2.like_id AND ul1.entity_id != ul2.entity_id
AND ul1.entity_id =  '" . $ent . "' ) GROUP BY like_id";
                $likecountquery = mysql_query($mutuallike);
                $likecount = mysql_num_rows($likecountquery);

                if ($likecount > 0) {
                    $totalcount = $likecount;
                } else {
                    $totalcount = 0;
                }


                $mutualfried = "SELECT * FROM  `t_add_friend` WHERE entity_id IN ( '" . $entityId . "','" . $ent . "' ) AND friend_fb_id IN (SELECT ul2.friend_fb_id
        FROM t_add_friend ul1, t_add_friend ul2 WHERE ul1.friend_fb_id = ul2.friend_fb_id AND ul1.entity_id != ul2.entity_id
AND ul1.entity_id = '" . $ent . "')GROUP BY friend_fb_id";

                $mutualcount = mysql_query($mutualfried);
                $friendcount = mysql_num_rows($mutualcount);

                if ($friendcount > 0) {
                    $mutualfrd = $friendcount;
                } else {
                    $mutualfrd = 0;
                }
                if ($match['Fb_Id'] != $args['ent_user_fbid']) {
                    $marchedUsersArr[] = array('firstName' => $match['First_Name'],'status' => $match['status'],'fbId' => $match['Fb_Id'], 'pPic' => $match['Profile_Pic_Url'], 'mutualLikecount' => $totalcount, 'mutualFriendcout' => $mutualfrd, 'sex' => $match['Sex'], 'persDesc' => $match['TagLine'], 'age' => $match['age'], 'lat' => $match['Current_Lat'], 'long' => $match['Current_Long'], 'matchPercentage' => $percentage); //,'sharedLikes'=>$match['shared_like_count']); //, 'status' => $match['entity_status']
                }
            }

            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'matches' => $marchedUsersArr);
        } else {

            if (mysql_num_rows($getMatchesRes) == 1)
                return $this->_getStatusMessage(21, 19);
            else
                return $this->_getStatusMessage(22, 20);
        }
    }

    /*
     * Method name: findMatches_optional
     * Desc: this is option if user want to another  prefered user 
     * Input: Request data
     * Output:  Matched users details if available, else returns error message
     * param:ent_user_fbid
     */

    protected function findMatches_optional($args) {

        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 13);


        /*  $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */


        $entityId = $this->_getEntityId($args['ent_user_fbid']);
        // working query
        $getUserPrefQry = "select 
            p.Preference_Sex,p.Preference_lower_age,p.Preference_upper_age,p.Preference_radius,ed.Current_Lat,ed.Current_Long,ed.dob
            from t_preferences p, t_entity_details ed 
            where 
            ed.Entity_Id = p.Entity_Id and
            ed.Entity_Id = '" . $entityId . "'";

        /* original : errored
          $getUserPrefQry = "select
          p.Preference_Sex,p.Preference_lower_age,p.Preference_upper_age,p.Preference_upper_age,p.Preference_radius,ed.Current_Lat,ed.Current_Long,ed.dob
          from t_preferences p, t_entity_details ed
          where
          ed.Entity_Id = p.Entity_Id and
          ed.Entity_Id = '" . $this->User['entityId'] . "'";
         */

        $getUserPrefRes = mysql_query($getUserPrefQry, $this->db->conn);



        $prefRow = mysql_fetch_assoc($getUserPrefRes);




//        print_r($prefRow);
        if ($prefRow['Preference_Sex'] == '3')
            $pref_sex_str = "ed.Sex = '1' or ed.Sex = '2'";
        else
            $pref_sex_str = "ed.Sex = '" . $prefRow['Preference_Sex'] . "'";


        if ($prefRow['Preference_lower_age'] == 0 && $prefRow['Preference_upper_age'] == 0)
            return $this->_getStatusMessage(19, 17);

        /* $getMatchesQry = "
          select ed.Entity_Id as entId,ed.First_Name,ed.Current_Lat,ed.Current_Long,ed.Profile_Pic_Url,ed.Sex,ed.Personal_Desc,ed.Fb_Id,ent.Last_Active_Dt_Time,
          YEAR(NOW()) - YEAR(ed.dob) - (RIGHT(NOW(), 5) < RIGHT(ed.DOB, 5)) as age
          from t_entity_details ed,t_entity ent
          where
          ed.Entity_Id = ent.Entity_Id and
          ent.status = 1 "; */


        // working query
        $getMatchesQry = "
            select ed.Entity_Id as entId,ed.First_Name,ed.Profile_Pic_Url,ed.Sex,ed.Current_Lat,ed.Current_Long,ed.Personal_Desc,ed.Fb_Id,ent.Last_Active_Dt_Time,
          YEAR(NOW()) - YEAR(ed.dob) - (RIGHT(NOW(), 5) < RIGHT(ed.DOB, 5)) as age
            from t_entity_details ed,t_entity ent 
            where 
            ed.Entity_Id = ent.Entity_Id and
            ent.status = 1 and
            ed.Entity_Id NOT IN (select Entity2_Id from t_likes where Entity1_Id = '" . $entityId . "' and Like_Flag = '1' OR  Like_Flag = '2' OR  Like_Flag = '3') 			
			and
            (3959 * acos( cos( radians('" . $prefRow['Current_Lat'] . "') ) * cos( radians(ed.Current_Lat) ) * cos( radians(ed.Current_Long) - radians('" . $prefRow['Current_Long'] . "') ) + sin( radians('" . $prefRow['Current_Lat'] . "') ) * sin( radians(ed.Current_Lat) ) ) ) <= " . $prefRow['Preference_radius'] . " 			
			and
            (" . $pref_sex_str . ") 			
            having 
            age BETWEEN '" . $prefRow['Preference_lower_age'] . "' AND '" . $prefRow['Preference_upper_age'] . "'";


        $getMatchesRes = mysql_query($getMatchesQry, $this->db->conn);




        if (mysql_num_rows($getMatchesRes) > 1) {

            $errMsgArr = $this->_getStatusMessage(20, 18);

            $marchedUsersArr = array();

            while ($match = mysql_fetch_assoc($getMatchesRes)) {
                $ent = $match['entId'];
                $matchperc = '';
                $getUserans = "select * from t_detail_user_ans where Entity_Id = '" . $entityId . "'";

                $getUseranspref = mysql_query($getUserans, $this->db->conn);
                $totalanswe = mysql_num_rows($getUseranspref);
                while ($data = mysql_fetch_array($getUseranspref)) {
                    $matchuser = "select * from t_detail_user_ans where Entity_Id = '" . $ent . "'  AND  d_id='" . $data['d_id'] . "'";
                    $matchuserquery = mysql_query($matchuser, $this->db->conn);
                    while ($data1 = mysql_fetch_array($matchuserquery)) {

                        $them = $data['them'];

                        $themans = explode(',', $them);

                        foreach ($themans as $answer) {

                            if ($data1['user_ans'] == $answer) {
                                $matchperc = $matchperc + 1;
                            }
                        }
                    }
                }


                $percentage = 100 * $matchperc / $totalanswe;
                $percentage = sprintf("%.2f", $percentage);
//$percentage = ceil($percentage);

                if ($percentage == false) {
                    $percentage = '0';
                }

                if ($match['Fb_Id'] != $args['ent_user_fbid']) {
                    $marchedUsersArr[] = array('firstName' => $match['First_Name'], 'fbId' => $match['Fb_Id'], 'pPic' => $match['Profile_Pic_Url'], 'mutualLikecount' => $totalcount, 'mutualFriendcout' => $mutualfrd, 'sex' => $match['Sex'], 'persDesc' => $match['TagLine'], 'age' => $match['age'], 'lat' => $match['Current_Lat'], 'long' => $match['Current_Long'], 'matchPercentage' => $percentage); //,'sharedLikes'=>$match['shared_like_count']); //, 'status' => $match['entity_status']
                }
            }

            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'matches' => $marchedUsersArr);
        } else {

            if (mysql_num_rows($getMatchesRes) == 0)
                return $this->_getStatusMessage(21, 19);
            else
                return $this->_getStatusMessage(22, 20);
        }
    }

    
    
    
    /*
      protected function mutual_friend($args) {

      if ($args['ent_friend_id'] == '')
      return $this->_getStatusMessage(1, 200);

      $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

      if (is_array($returned))
      return $returned;

      //,(select Like_Flag from Likes where Entity1_Id = '" . $this->User['entityId'] . "') ,,,TIMESTAMPDIFF(YEAR,edet.DOB,NOW()) AS age,

      $ent = $this->_getEntityId($args['ent_friend_id']);

      $mutualfried = "SELECT * FROM  `t_add_friend` WHERE entity_id IN ( '" . $this->User['entityId'] . "','" . $ent . "' ) AND friend_fb_id IN (SELECT ul2.friend_fb_id
      FROM t_add_friend ul1, t_add_friend ul2 WHERE ul1.friend_fb_id = ul2.friend_fb_id AND ul1.entity_id != ul2.entity_id
      AND ul1.entity_id = '" . $ent . "')GROUP BY friend_fb_id";




      $mutuallikes = " SELECT * FROM  `t_add_likes` WHERE entity_id IN (  '" . $this->User['entityId'] . "','" . $ent . "' )
      AND like_id IN ( SELECT ul2.like_id FROM t_add_likes ul1, t_add_likes ul2 WHERE ul1.like_id = ul2.like_id AND ul1.entity_id != ul2.entity_id
      AND ul1.entity_id =  '" . $ent . "') GROUP BY like_id";

      $getmutualfrd = mysql_query($mutualfried, $this->db->conn);
      $getmutuallike = mysql_query($mutuallikes, $this->db->conn);

      $mutualfrdarray = array();
      $mutuallikearray = array();

      if (mysql_num_rows($getmutuallike) > 0) {

      $errMsgArr = $this->_getStatusMessage(50, 30);

      while ($likeRow = mysql_fetch_assoc($getmutuallike)) {
      $mutuallikearray[] = array('entity_id' => $likeRow['entity_id'], 'like_id' => $likeRow['like_id'], 'like_picture' => $likeRow['like_picture']); //, 'age' => $likeRow['age']
      }
      } else {

      $errMsgArr = $this->_getStatusMessage(51, 31);
      }





      if (mysql_num_rows($getmutualfrd) > 0) {

      $errMsgArr = $this->_getStatusMessage(50, 30);

      while ($friend = mysql_fetch_assoc($getmutualfrd)) {
      $mutualfrdarray[] = array('entity_id' => $friend['entity_id'], 'friend_fb_id' => $friend['friend_fb_id'], 'friend_name' => $friend['friend_name'], 'friend_picture' => $friend['friend_picture']); //, 'age' => $likeRow['age']
      }
      } else {

      $errMsgArr = $this->_getStatusMessage(51, 31);
      }

      return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'mutuallikes' => $mutuallikearray,'mutualfriend'=>$mutualfrdarray);
      }



     */
    /*
      protected function addLikes($args, $entity_id = NULL) {

      if ($args['ent_likes'] == '')
      return $this->_getStatusMessage(1, 21);

      if ($entity_id == NULL) {

      $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

      if (is_array($returned))
      return $returned;

      $entity_id = $this->User['entityId'];
      }

      $delLikesQry = "delete from t_add_likes where entity_id = '" . $entity_id . "'";
      $delLikesRes = mysql_query($delLikesQry, $this->db->conn);
      if (mysql_affected_rows() > 0) {
      $name = $args['ent_name'];
      $pic = $args['ent_picture'];
      if ($this->_insertLikes($entity_id, $name, $pic, $args['ent_likes']))
      return $this->_getStatusMessage(26, 22);
      else
      return $this->_getStatusMessage(27, 23);
      } else {
      if ($delLikesRes) {
      $name = $args['ent_names'];
      $pic = $args['ent_pictures'];
      $like = $args['ent_likes'];
      if ($this->_insertLikes($entity_id, $name, $pic, $like))
      return $this->_getStatusMessage(26, 24);
      else
      return $this->_getStatusMessage(27, 25);
      } else {
      return $this->_getStatusMessage(28, 26);
      }
      }
      }

      protected function addFriend_id($args, $entity_id = NULL) {


      if ($args['ent_frd_fb_id'] == '' || $args['ent_frd_names'] == '' || $args['ent_frd_pics'] == '')
      return $this->_getStatusMessage(1, 21);


      if ($entity_id == NULL) {

      $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

      if (is_array($returned))
      return $returned;

      $entity_id = $this->User['entityId'];
      }

      $delLikesQry = "delete from t_add_friend where entity_id = '" . $entity_id . "'";
      $delLikesRes = mysql_query($delLikesQry, $this->db->conn);
      if (mysql_affected_rows() > 0) {
      $name = $args['ent_frd_names'];
      $pic = $args['ent_frd_pics'];
      $f_id = $args['ent_frd_fb_id'];
      if ($this->_insertfrind($entity_id, $name, $pic, $f_id))
      return $this->_getStatusMessage(26, 22);
      else
      return $this->_getStatusMessage(27, 23);
      } else {

      if ($delLikesRes) {

      $name = $args['ent_frd_names'];

      $pic = $args['ent_frd_pics'];
      $f_id = $args['ent_frd_fb_id'];
      if ($this->_insertfrind($entity_id, $name, $pic, $f_id))
      return $this->_getStatusMessage(26, 24);
      else
      return $this->_getStatusMessage(27, 25);
      } else {
      return $this->_getStatusMessage(28, 26);
      }
      }
      }

      protected function _insertfrind($entity_id, $name, $pic, $like_string) {




      $frd_id_arr = array_filter(array_unique(explode(',', $like_string)));
      $name_arr = array_filter(array_unique(explode(',', $name)));
      $pict_aray = array_filter(array_unique(explode(',', $pic)));

      $insert_count = 0;
      $count = count($frd_id_arr);
      for ($i = 0; $i < $count; $i++) {

      $insertLikeQry = "insert into t_add_friend(friend_fb_id, friend_name, friend_picture, entity_id) values('" . $frd_id_arr[$i] . "', '" . $name_arr[$i] . "', '" . $pict_aray[$i] . "', '" . $entity_id . "')";
      $insertLikeRes = mysql_query($insertLikeQry, $this->db->conn);
      $insert_count++;
      }


     */

    /*
      foreach ($likes_arr as $value) {


      $insertLikeQry = "insert into t_user_likes(like_id, entity_id) values('" . $value . "', '" . $entity_id . "')";
      $insertLikeRes = mysql_query($insertLikeQry, $this->db->conn);
      if ($insertLikeRes) {
      $insert_count++;
      }
      } */
    /*
      if (count($frd_id_arr) == $insert_count) {
      return 1;
      } else {
      return 0;
      }
      }

      protected function _insertLikes($entity_id, $name, $pic, $like_string) {




      $likes_arr = array_filter(array_unique(explode(',', $like_string)));
      $name_arr = array_filter(array_unique(explode(',', $name)));
      $pict_aray = array_filter(array_unique(explode(',', $pic)));

      $insert_count = 0;
      $count = count($likes_arr);
      for ($i = 0; $i < $count; $i++) {

      $insertLikeQry = "insert into t_add_likes(like_id, like_name, like_picture, entity_id) values('" . $likes_arr[$i] . "', '" . $name_arr[$i] . "', '" . $pict_aray[$i] . "', '" . $entity_id . "')";
      $insertLikeRes = mysql_query($insertLikeQry, $this->db->conn);
      $insert_count++;
      }
      /*
      foreach ($likes_arr as $value) {


      $insertLikeQry = "insert into t_user_likes(like_id, entity_id) values('" . $value . "', '" . $entity_id . "')";
      $insertLikeRes = mysql_query($insertLikeQry, $this->db->conn);
      if ($insertLikeRes) {
      $insert_count++;
      }
      } */
    /*    if (count($likes_arr) == $insert_count) {
      return 1;
      } else {
      return 0;
      }
      }

     */



    /*
     * Method name: setLikes
     * Desc: Set user likes from FB
     * Input: Request data
     * Output:  Success message if completed, else returns error message
     */

    /*  protected function setLikes($args, $entity_id = NULL) {

      if ($args['ent_likes'] == '')
      return $this->_getStatusMessage(1, 21);

      if ($entity_id == NULL) {

      $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

      if (is_array($returned))
      return $returned;

      $entity_id = $this->User['entityId'];
      }

      $delLikesQry = "delete from t_user_likes where entity_id = '" . $entity_id . "'";
      $delLikesRes = mysql_query($delLikesQry, $this->db->conn);
      if (mysql_affected_rows() > 0) {

      if ($this->_insertLikes($entity_id, $args['ent_likes']) == '1')
      return $this->_getStatusMessage(26, 22);
      else
      return $this->_getStatusMessage(27, 23);
      } else {
      if ($delLikesRes) {

      if ($this->_insertLikes($entity_id, $args['ent_likes']) == '1')
      return $this->_getStatusMessage(26, 24);
      else
      return $this->_getStatusMessage(27, 25);
      } else {
      return $this->_getStatusMessage(28, 26);
      }
      }
      }
     */
    /*
     * Method name: inviteAction
     * Desc: Invite user for like or a match
     * Input: Request data
     * Output:  Success message if completed, else returns error message
     * param:ent_invitee_fbid,ent_user_action,ent_user_fbid
     */

    
    protected function inviteAction($args) {

        if ($args['ent_invitee_fbid'] == '' || $args['ent_user_action'] == '' || $args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 27);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);
          if (is_array($returned))
          return $returned;
         */

        $entityId = $this->_getEntityId($args['ent_user_fbid']);



        $inviteeEntityId = $this->_getEntityId($args['ent_invitee_fbid']);

        if (is_array($inviteeEntityId))
            return $inviteeEntityId;

        $curr_date = time();
        $curr_gmt_date = gmdate('Y-m-d H:i:s', $curr_date);

        $query_flag = 0;

        $checkPrevLikeQry = "select Like_Id from t_likes where Entity1_Id = '" . $entityId . "' and Entity2_Id = '" . $inviteeEntityId . "'";
        $checkPrevLikeRes = mysql_query($checkPrevLikeQry, $this->db->conn);

        if (mysql_num_rows($checkPrevLikeRes) > 0) {

            $updateE2RowQry = "update t_likes set Like_Flag = '" . $args['ent_user_action'] . "',Update_Dt = '" . $curr_gmt_date . "' where Entity1_Id = '" . $entityId . "' and Entity2_Id = '" . $inviteeEntityId . "'";
            mysql_query($updateE2RowQry, $this->db->conn);

            if (mysql_affected_rows() > 0)
                $query_flag++;
        } else {

            $insertLikeQry = "insert into t_likes(Entity1_Id,Entity2_Id,Like_Flag,Like_DateTime,Dislike_Count,Update_Dt) 
                values('" . $entityId . "','" . $inviteeEntityId . "','" . $args['ent_user_action'] . "','" . $curr_gmt_date . "','0','" . $curr_gmt_date . "')";

            mysql_query($insertLikeQry, $this->db->conn);

            if (mysql_insert_id() > 0)
                $query_flag++;
        }

        $checkOtherLikeQry = "select Like_Id,Like_Flag from t_likes where Entity2_Id = '" . $entityId . "' and Entity1_Id = '" . $inviteeEntityId . "' and Like_flag = '1'";
        $checkOtherLikeRes = mysql_query($checkOtherLikeQry, $this->db->conn);
        if (mysql_num_rows($checkOtherLikeRes) > 0) {
            $likeRow = mysql_fetch_assoc($checkOtherLikeRes);
            if ($args['ent_user_action'] == '1') {
                $updateE1RowQry = "update t_likes set Like_Flag = '3',Update_Dt = '" . $curr_gmt_date . "' where Entity1_Id = '" . $entityId . "' and Entity2_Id = '" . $inviteeEntityId . "'";
                mysql_query($updateE1RowQry, $this->db->conn);
                $updatedRows1 = mysql_affected_rows();

                $updateE2RowQry = "update t_likes set Like_Flag = '3',Update_Dt = '" . $curr_gmt_date . "' where Like_Id = '" . $likeRow['Like_Id'] . "'";
                mysql_query($updateE2RowQry, $this->db->conn);
                $updatedRows2 = mysql_affected_rows();

                if ($updatedRows1 > 0 && $updatedRows2 > 0) {

                    $recEntityArr[] = $inviteeEntityId;
                    $message = 'Congratulations! You got a match in '.APP_TITLE.' app!';
                    $notifType = '3';

                    $push = $this->_sendPush($entityId, $recEntityArr, $message, $notifType, $this->User['firstName'], $this->User['fbId'], $curr_gmt_date, 0, 0);
//print_r($push);
                    $entityDet = $this->_getEntityDet($inviteeEntityId);

                    $errMsgArr = $this->_getStatusMessage(55, 201);
                    return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'uFbId' => $entityDet['Fb_Id'], 'uName' => $entityDet['First_Name'], 'pPic' => $entityDet['Profile_Pic_Url']);
                }
            } else {
                $updateE1RowQry = "update t_likes set Like_Flag = '2',Dislike_Count = Dislike_Count + 1,Update_Dt = '" . $curr_gmt_date . "' where Entity1_Id = '" . $entityId . "' and Entity2_Id = '" . $inviteeEntityId . "'";
                mysql_query($updateE1RowQry, $this->db->conn);

                if (mysql_affected_rows() > 0)
                    $query_flag++;
            }
        }

        if ($query_flag > 0)
            return $this->_getStatusMessage(29, 28);
        else
            return $this->_getStatusMessage(37, 29);
    }

    /*
     * Method name: getProfileMatches
     * Desc: Get the user profiles who are already matched
     * Input: Request data
     * Output:  Success message if completed, else returns error message
     * param:ent_user_fbid,ent_datetime;
     */

    protected function getProfileMatches($args) {

        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 200);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);
          if (is_array($returned))
          return $returned; */

        $entityId = $this->_getEntityId($args['ent_user_fbid']);


//,(select Like_Flag from Likes where Entity1_Id = '" . $this->User['entityId'] . "') ,,,TIMESTAMPDIFF(YEAR,edet.DOB,NOW()) AS age,


        if ($args['ent_datetime'] != '')
            $date_string = " and Update_Dt < '" . $args['ent_datetime'] . "'";
        else
            $date_string = '';

        $getProfileMatchesQry = "select edet.Entity_Id as entId,edet.Profile_Pic_Url,edet.First_Name,ent.Last_Active_Dt_Time,ent.Unique_Identifier ,(select Like_Flag from t_likes where Entity1_Id = '" . $entityId . "' and Entity2_Id = entId group by Like_Flag) as flag 
                from t_entity ent, t_entity_details edet 
                where 
                ent.Entity_Id = edet.Entity_Id 
                and ent.status = '1'
          and edet.Entity_Id in (select distinct Entity2_Id from t_likes where Entity1_Id = '" . $entityId . "' and Like_Flag IN (3,4))
          ";
        $getProfileMatchesRes = mysql_query($getProfileMatchesQry, $this->db->conn);

        $likesArr = array();

        if (mysql_num_rows($getProfileMatchesRes) > 0) {

            $errMsgArr = $this->_getStatusMessage(50, 30);

            while ($likeRow = mysql_fetch_assoc($getProfileMatchesRes)) {
            
            
            
           
            
                $likesArr[] = array('fbId' => $likeRow['Unique_Identifier'], 'fName' => $likeRow['First_Name'], 'ladt' => $likeRow['Last_Active_Dt_Time'], 'pPic' => $likeRow['Profile_Pic_Url'], 'flag' => $likeRow['flag']); //, 'age' => $likeRow['age']
            }
        } else {

            $errMsgArr = $this->_getStatusMessage(51, 31);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'likes' => $likesArr);
    }

    /*
     * Method name: blockUser
     * Desc: Block the user who is already in the matched list
     * Input: Request data
     * Output:  Success message if completed, else returns error message
     * param:ent_user_fbid,ent_flag,ent_user_block_fbid
     */

    protected function blockUser($args) {

        if ($args['ent_user_fbid'] == '' || $args['ent_flag'] == '')
            return $this->_getStatusMessage(1, 32);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned;
         */
        $entityId = $this->_getEntityId($args['ent_user_fbid']);

        $blockingEntityId = $this->_getEntityId($args['ent_user_block_fbid']);

        if (is_array($blockingEntityId))
            return $blockingEntityId;

        $updateFlagRowQry = "update t_likes set Like_Flag = '" . $args['ent_flag'] . "' where (Entity1_Id = '" . $entityId . "' and Entity2_Id = '" . $blockingEntityId . "') or (Entity1_Id = '" . $blockingEntityId . "' and Entity2_Id = '" . $entityId . "')";
        $updateFlagRowRes = mysql_query($updateFlagRowQry, $this->db->conn);

        if ($args['ent_flag'] == '3')
            $errNum = 58;
        else
            $errNum = 52;

        if (mysql_affected_rows() > 0)
            return $this->_getStatusMessage($errNum, 33);
        else if ($updateFlagRowRes)
            return $this->_getStatusMessage($errNum, 34);
        else
            return $this->_getStatusMessage(37, 34);
    }

    /*
     * Method name: getNotifications
     * Desc: Get notification for the current users
     * Input: Request data
     * Output:  Notifications array with success message if completed, else returns error message
     * param:ent_user_fbid
     */

    protected function getNotifications($args) {


        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */

        $entityId = $this->_getEntityId($args['ent_user_fbid']);

        $getNotesQry = "select notif_type,message,(select Unique_Identifier from t_entity where Entity_Id = sender) as FBId from t_notifications where reciever = '" . $entityId . "'";
        $getNotesRes = mysql_query($getNotesQry, $this->db->conn);

        if (mysql_num_rows($getNotesRes) > 0) {

            $notesArr = array();
            while ($noteRow = mysql_fetch_assoc($getNotesRes)) {

                $notesArr[] = array('fbId' => $noteRow['FBId'], 'notifType' => $noteRow['notif_type'], 'message' => $noteRow['message']);
            }

            $errMsgArr = $this->_getStatusMessage(35, 35);
            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'notifications' => $notesArr);
        } else {

            if ($getNotesRes)
                return $this->_getStatusMessage(36, 36);
            else
                return $this->_getStatusMessage(37, 37);
        }
    }

    /*
     * Method name: getProfile
     * Desc: Get profile of any users
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     * pamram:ent_user_fbid
     */

    protected function getProfile($args) {

        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 38);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);
         */
        $entityId = $this->_getEntityId($args['ent_user_fbid']);

        if (is_array($returned))
            return $returned;

        if (is_array($entityId))
            return $entityId;

        $getProfileQry = "select TIMESTAMPDIFF(YEAR,edet.DOB,NOW()) AS age,ent.Last_Active_Dt_Time,edet.Personal_Desc,edet.Profile_Pic_Url,edet.First_Name,edet.Current_Lat,edet.Current_Long,edet.Status 
            from t_entity ent,t_entity_details edet 
            where ent.Entity_Id = edet.Entity_Id and ent.Unique_Identifier = edet.Fb_Id and ent.Entity_Id = '" . $entityId . "'";
        $getProfileRes = mysql_query($getProfileQry, $this->db->conn);
//echo $getProfileQry;
        if (mysql_num_rows($getProfileRes) > 0) {

            $entityDet = mysql_fetch_assoc($getProfileRes);

            $errMsgArr = $this->_getStatusMessage(40, 39);

            $getImagesQry = "select distinct image_url from t_images where entity_id = '" . $entityId . "'";
            $getImagesRes = mysql_query($getImagesQry, $this->db->conn);

            $imageArr = array();

            if (mysql_num_rows($getImagesRes) > 0) {
                while ($image = mysql_fetch_assoc($getImagesRes)) {
                    $imageArr[] = $image['image_url'];
                }
            }

            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'],
                'profilePic' => $entityDet['Profile_Pic_Url'], 'age' => $entityDet['age'], 'lati' => $entityDet['Current_Lat'], 'long' => $entityDet['Current_Long'],'status' => $entityDet['Status'], 'lastActive' => $entityDet['Last_Active_Dt_Time'], 'persDesc' => $entityDet['Personal_Desc'],
                'firstName' => $entityDet['First_Name'], 'images' => $imageArr
            );
        } else {
            return $this->_getStatusMessage(39, 40);
        }
    }

    /*
     * Method name: editProfile
     * Desc: Edit profile of any users
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     * param:ent_pers_desc,ent_user_fbid
     */

    protected function editProfile($args) {

        if ($args['ent_pers_desc'] == '' || $args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 41);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */
        $entityId = $this->_getEntityId($args['ent_user_fbid']);

        $editProfileQry = "update t_entity_details set Personal_Desc = '" . $args['ent_pers_desc'] . "' where Entity_Id = '" . $entityId . "'";
        $editProfileRes = mysql_query($editProfileQry, $this->db->conn);

        if (mysql_affected_rows() > 0)
            return $this->_getStatusMessage(32, 42);
        else if ($editProfileRes)
            return $this->_getStatusMessage(33, 43);
        else
            return $this->_getStatusMessage(34, 44);
    }

    /*
     * Method name: updateLocation
     * Desc: Update Location of any users
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     * param:ent_curr_lat,ent_curr_long,ent_user_fbid
     */

    protected function updateLocation($args) {

        if ($args['ent_curr_lat'] == '' || $args['ent_curr_long'] == '' || $args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 45);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */
        $entityId = $this->_getEntityId($args['ent_user_fbid']);

        $editProfileQry = "update t_entity_details set Current_Lat = '" . $args['ent_curr_lat'] . "',Current_Long = '" . $args['ent_curr_long'] . "' where Entity_Id = '" . $entityId . "'";
        $editProfileRes = mysql_query($editProfileQry, $this->db->conn);

        if (mysql_affected_rows() > 0)
            return $this->_getStatusMessage(42, 46);
        else if ($editProfileRes)
            return $this->_getStatusMessage(43, 47);
        else
            return $this->_getStatusMessage(37, 48);
    }

    /*
     * Method name: sendMessage
     * Desc: Edit profile of any users
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     * param:ent_message,ent_user_fbid,ent_user_recever_fbid
     */

    protected function sendMessage($args) {

        if ($args['ent_message'] == '' || $args['ent_user_fbid'] == '' || $args['ent_user_recever_fbid'] == '')
            return $this->_getStatusMessage(1, 49);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */
        $entityId = $this->_getEntityId($args['ent_user_fbid']);
        $recieverId = $this->_getEntityId($args['ent_user_recever_fbid']);

        $user = $this->_getEntityIddetail($entityId);
    
        if (is_array($recieverId))
            return $recieverId;

        $recEntityArr[] = $recieverId;

        $msg_type = 1;

        if (strlen($args['ent_message']) > 165) {
            $msg_type = 2;
            $args['ent_message'] = substr($args['ent_message'], 160) . '..';
        }

        $curr_date = time();
        $curr_gmt_date = date('Y-m-d H:i:s', $curr_date);

        $storeMsgQry = "insert into t_chatmessages(sender,receiver,message,msg_dt) 
            values('" . $entityId . "','" . $recieverId . "','" . $args['ent_message'] . "','" . $curr_gmt_date . "')";
        mysql_query($storeMsgQry, $this->db->conn);

        $insertedId = mysql_insert_id();

        if ($insertedId > 0) {

            $sendPush = $this->_sendPush($entityId, $recEntityArr, $args['ent_message'], '2', $user['First_Name'], $user['Fb_Id'], $curr_gmt_date, $insertedId, $msg_type);

            return $this->_getStatusMessage($sendPush['errNum'], 50);
        } else {

            return $this->_getStatusMessage(37, 51);
        }
    }

    /*
     * Method name: getChatMessage
     * Desc: Get message specifically according to the id
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     * extra : this ws not work in this app
     * param:ent_msg_id
     */
    /*
      protected function getChatMessage($args) {

      if ($args['ent_msg_id'] == '')
      return $this->_getStatusMessage(1, 57);

      $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

      if (is_array($returned))
      return $returned;
      //$entityId = $this->_getEntityId($args['ent_user_fbid']);
      //$msgIdsArr = explode(',', $args['ent_msg_id']);

      $getMsgQry = "select mid,message,sender as user_id,(select Unique_Identifier from t_entity where Entity_Id = user_id) as Fb_Id,(select First_Name from t_entity_details where Entity_Id = user_id) as sender_name,msg_dt from t_chatMessages where mid IN (" . $args['ent_msg_id'] . ")";
      $getMsgRes = mysql_query($getMsgQry, $this->db->conn);

      if (mysql_num_rows($getMsgRes) > 0) {

      $errMsgArr = $this->_getStatusMessage(56, 58);
      $msgArr = array();

      while ($msgDet = mysql_fetch_assoc($getMsgRes)) {
      $msgArr[] = array('mid' => $msgDet['mid'], 'sname' => $msgDet['sender_name'], 'msg' => $msgDet['message'], 'sfid' => $msgDet['Fb_Id'], 'dt' => $msgDet['msg_dt']);
      }
      } else {
      $errMsgArr = $this->_getStatusMessage(57, 59);
      }
      return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'chat' => $msgArr);
      }
     */
    /*
     * Method name: getChatHistory
     * Desc: Get chat histopry of any users
     * Input: Request data
     * Output:  Complete chat history details if available, else error message
     * param:ent_user_fbid,ent_user_fbid
     */

    protected function getChatHistory($args) {

        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 52);

        /* $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */
        $entityid = $this->_getEntityId($args['ent_user_fbid']);
        $recieverId = $this->_getEntityId($args['ent_user_recever_fbid']);

        if (is_array($recieverId))
            return $recieverId;

        if ($args['ent_chat_page'] == '')
            $pageNum = 1;
        else
            $pageNum = (int) $args['ent_chat_page'];

        $lowerLimit = ($this->chatMessagePageSize * $pageNum) - $this->chatMessagePageSize;
        $upperLimit = $this->chatMessagePageSize * $pageNum;

        $msgArr = array();

        $getHistoryQry = "select sender,mid,message,msg_dt,(select Fb_Id from t_entity_details where Entity_Id = sender) as sender_fb_Id,(select First_Name from t_entity_details where Entity_Id = sender) as sender_name,(select Fb_Id from t_entity_details where Entity_Id = receiver) as reciever_fb_Id 
            from t_chatmessages 
            where 
            (
            (sender = '" . $entityid . "' and receiver = '" . $recieverId . "') 
                or 
            (sender = '" . $recieverId . "' and receiver = '" . $entityid . "')
            )
            limit " . $lowerLimit . "," . $upperLimit;
        $getHistoryRes = mysql_query($getHistoryQry, $this->db->conn);

        if (mysql_num_rows($getHistoryRes) > 0) {

            $errMsgArr = $this->_getStatusMessage(47, 53);

            while ($msg = mysql_fetch_assoc($getHistoryRes)) {
                $msgArr[] = array('mid' => $msg['mid'], 'sname' => $msg['sender_name'], 'rfid' => $msg['reciever_fb_Id'], 'sfid' => $msg['sender_fb_Id'], 'msg' => $msg['message'], 'dt' => $msg['msg_dt']);
            }
        } else {
            $errMsgArr = $this->_getStatusMessage(48, 54);
        }

        return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'chat' => $msgArr);
    }

    /*
     * Method name: getChatHistory
     * Desc: Get chat histopry of any users
     * Input: Request data
     * Output:  Complete chat history details if available, else error message
     * param:ent_user_fbid,
     */

    protected function getPreferences($args) {
        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 52);
        /*
          $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

          if (is_array($returned))
          return $returned; */
        $entityid = $this->_getEntityId($args['ent_user_fbid']);
        $getSettingsQry = "select Preference_Sex,Preference_lower_age,Preference_upper_age,Preference_radius,(select sex from t_entity_details where Entity_Id = '" . $entityid . "') as sex 
            from t_preferences where
            Entity_Id = '" . $entityid . "'";

        $getSettingsRes = mysql_query($getSettingsQry, $this->db->conn);

        $errMsgArr = $this->_getStatusMessage(53, 59);

        if (mysql_num_rows($getSettingsRes) > 0) {
            $prefDet = mysql_fetch_assoc($getSettingsRes);
            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'],
                'prSex' => $prefDet['Preference_Sex'], 'prLAge' => $prefDet['Preference_lower_age'], 'prUAge' => $prefDet['Preference_upper_age'], 'prRad' => $prefDet['Preference_radius'], 'sex' => $prefDet['sex']);
        } else {
            return $this->_getStatusMessage(54, 60);
        }
    }

//auto destruction mesage not use
    /*
      protected function delete_message() {


      if (!isset($_POST['sender_id']) || !isset($_POST['recive_id']) || empty($_POST['sender_id']) || empty($_POST['recive_id'])) {
      $json["message"] = "sender_id / recive_id  must be set and not be empty";
      $json["status"] = "fail";

      echo json_encode($json);
      exit;
      }

      $sender_id = $_POST["sender_id"];
      $recive_id = $_POST["recive_id"];

      //First check that del_user1 is empty or not ?
      $sql = "SELECT user1 FROM t_chatmessages WHERE (sender=$sender_id OR sender=$recive_id) AND (receiver=$sender_id OR receiver=$recive_id)";

      $flag = 0;
      $result = mysql_query($sql);
      $del_user_id = "";
      while ($result_set = mysql_fetch_array($result)) {

      $del_user_id = $result_set["user1"];


      if ($del_user_id != $sender_id) {
      $sql = "UPDATE t_chatmessages SET user1=$recive_id WHERE (sender=$sender_id OR sender=$recive_id) AND (receiver=$recive_id OR receiver=$sender_id)";
      //$del_sql = "DELETE FROM notifications WHERE (from_id=$from_id OR from_id=$to_id) AND (to_id=$from_id OR to_id=$to_id) AND del_user1!=0";
      //echo $del_sql; exit;
      mysql_query($sql);
      }

      if (empty($result_set["user1"])) {
      $flag = 1;
      break;
      }
      }


      if ($flag == 1) {

      $sql1 = "UPDATE t_chatmessages SET user1=$sender_id WHERE (sender=$recive_id) AND (receiver=$sender_id )";
      $sql = "UPDATE t_chatmessages SET user1=$sender_id WHERE (sender=$sender_id OR sender=$recive_id) AND (receiver=$recive_id OR receiver=$sender_id)";
      //$sql="UPDATE notifications SET del_user1=$from_id WHERE (from_id=$to_id) AND ( to_id=$from_id)";

      mysql_query($sql);
      mysql_query($sql1);
      } else {
      if ($del_user_id != $sender_id) {
      $sql = "UPDATE t_chatmessages SET user1=$sender_id WHERE (sender=$recive_id OR sender=$sender_id) AND (receiver=$sender_id OR receiver=$recive_id)";
      //$del_sql = "DELETE FROM t_chatmessages WHERE (sender=$sender_id OR sender=$recive_id) AND (receiver=$sender_id OR sender=$recive_id) AND user1!=0";
      //echo $del_sql; exit;
      mysql_query($del_sql);
      } else {
      $json["message"] = "message is deleted successfully";
      $json["status"] = "success";
      json_encode($json);
      return false;
      }
      }

      if (mysql_affected_rows() >= 1) {
      $json["message"] = "message is deleted successfully";
      $json["status"] = "success";
      } else {
      $json["message"] = "message is not deleted";
      $json["status"] = "fail";
      }



      echo json_encode($json);
      }
     */
    /*
     * Method name: updateSession
     * Desc: Updates user session
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     * extra:this ws not work in this app
     */
    /*
      protected function updateSession($args) {

      $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

      if ((is_array($returned) && $returned['errNum'] == 9) || !is_array($returned)) {

      $token_obj = new ManageToken();

      $updateArr = $token_obj->updateSessToken($this->User['entityId'], $args['ent_dev_id']);

      $errMsgArr = $this->_getStatusMessage(59, 71);
      return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'token' => $updateArr['Token'], 'expiryLocal' => $updateArr['Expiry_local'], 'expiryGMT' => $updateArr['Expiry_GMT'], 'flag' => $updateArr['Flag']);
      } else {
      return $this->_getStatusMessage(60, 72);
      }
      }
     */
    /*
     * Method name: logout
     * Desc: Edit profile of any users
     * Input: Request data
     * Output:  Complete profile details if available, else error message
     */
    /*
      protected function logout($args) {

      $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);

      if (is_array($returned))
      return $returned;

      $logoutQry = "update t_user_sessions set loggedIn = '2' where oid = '" . $this->User['entityId'] . "' and sid = '" . $this->User['sid'] . "'";
      mysql_query($logoutQry, $this->db->conn);

      if (mysql_affected_rows() > 0)
      return $this->_getStatusMessage(41, 55);
      else
      return $this->_getStatusMessage(37, 56);
      }
     */
    /*
     * Method name: deleteAccount
     * Desc: Delete account profile of any users
     * Input: Request data
     * Output:  Complete details if available, else error message
     * param:ent_user_fbid
     */

    // CORRECT
    
    protected function deleteAccount($args) {
        if ($args['ent_user_fbid'] == '')
            return $this->_getStatusMessage(1, 52);

        $entityid = $this->_getEntityId($args['ent_user_fbid']);


        // $deleteQry = "delete from t_entity_detail set loggedIn = '2' where oid = '" . $this->User['entityId'] . "' and sid = '" . $this->User['sid'] . "'";
        $deleteQry = "DELETE FROM t_user_sessions, t_entity_details,t_entity USING t_entity_details INNER JOIN t_user_sessions INNER JOIN t_entity
WHERE t_entity_details.Entity_Id='" . $entityid . "' AND t_user_sessions.oid='" . $entityid . "' AND t_entity.	Entity_Id='" . $entityid . "'";

        mysql_query($deleteQry, $this->db->conn);

        if (mysql_affected_rows() > 0)
            return $this->_getStatusMessage(64, 55);
        else
            return $this->_getStatusMessage(37, 56);
    }

    /*
     * Method name: testAndiPush
     * Desc: To test push for android
     * Input: Request data
     * Output:  success if sent, else error message
     */

    protected function testAndiPush($args) {

        if ($args['ent_api_key'] == '' || $args['ent_dev_id'] == '' || $args['ent_message'] == '')
            return $this->_getStatusMessage(1, 57);

        $this->androidApiKey = $args['ent_api_key'];
        $tokenArr = array($args['ent_dev_id']);

        echo $this->androidApiKey . '---';
        print_r($tokenArr);
        echo '---';

        $return_res = $this->_sendAndroidPush($tokenArr, $args['ent_message'], '0', 'fbid', 'sender_name', 'datetime', 0, 0);
        echo $return_res['result'];
        if ($return_res['errorNo'] == 44)
            return array('push' => 'sent');
        else
            return array('push' => 'failed');
    }

    /*
     * Method name: testIosPush
     * Desc: To test push for apple
     * Input: Request data
     * Output:  success if sent, else error message
     */

    protected function testIosPush($args) {

        if ($_FILES['ent_ios_cer'] == '' || $args['ent_cer_pass'] == '' || $args['ent_message'] == '' || $args['ent_push_token'] == '')
            return $this->_getStatusMessage(1, 58);

        $allowedExts = array("pem");
        $_FILES["file"] = $_FILES['ent_ios_cer'];

        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        if (in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {

                if (file_exists("test/" . $_FILES["file"]["name"]))
                    unlink($_FILES["file"]["name"]);

                move_uploaded_file($_FILES["file"]["tmp_name"], "test/" . $_FILES["file"]["name"]);
                echo $_FILES["file"]["name"] . " -->Stored";

                $ce = $this->ios_cert_path;
                $pas = $this->ios_cert_pwd;

                if ($args['ent_cer_type'] == '1')
                    $this->ios_cert_server = "ssl://gateway.sandbox.push.apple.com:2195";
                else
                    $this->ios_cert_server = "ssl://gateway.push.apple.com:2195";


                echo 'Path:' . $ce . ',Pwd:' . $pas . ',Server:' . $this->ios_cert_server;

                $tokenArr = array($args['ent_push_token']);

                print_r($tokenArr);

                $return_res = $this->_sendApplePush($tokenArr, $args['ent_message'], '0', 'fbid', 'sender_name', 'datetime', 0, 0);
                // print_r($return_res);
                if ($return_res['errorNo'] == 44)
                    return array('push' => 'sent');
                else if ($return_res['errorNo'] == 30)
                    return array('error' => "Connection failed");
                else
                    return array('push' => 'failed');
            }
        } else {
            return array('error' => "Please provice a .pem file");
        }
    }

    /*             ----------------                 HELPER METHODS             ------------------             */
    /*
     * Method name: _validate_token
     * Desc: Authorizes the user with token provided
     * Input: Token
     * Output:  gives entity details if available else error msg
     */
    /*
      protected function _validate_token($ent_sess_token, $ent_dev_id) {

      if ($ent_sess_token == '' || $ent_dev_id == '') {

      return $this->_getStatusMessage(1, 101);
      } else {

      $sessDetArr = $this->_getSessDetails($ent_sess_token, $ent_dev_id);
      //            print_r($sessDetArr);
      if ($sessDetArr['flag'] == '0') {
      $this->_updateActiveDateTime($sessDetArr['entityId']);
      $this->User = $sessDetArr;
      } else if ($sessDetArr['flag'] == '1') {
      return $this->_getStatusMessage(9, 102);
      } else {
      return $this->_getStatusMessage(31, 103);
      }
      }
      }
     */
    /*
     * Method name: _checkEntityLogin
     * Desc: Checks the unique id with the authentication type
     * Input: Unique id and the auth type
     * Output:  entity details if true, else false
     */
   
      protected function _checkEntityLogin($id, $auth_type) {

      $checkFBIdQry = "select Entity_Id as entId,(select Profile_Pic_Url from t_entity_details where Entity_Id = entId) as Profile_Pic_Url,(select Status from t_entity_details where Entity_Id = entId) as status from t_entity where Unique_Identifier = '" . $id . "' and authType = '" . $auth_type . "'";
      $checkFBIdRes = mysql_query($checkFBIdQry, $this->db->conn);

      if (mysql_num_rows($checkFBIdRes) == 1) {

      $userDet = mysql_fetch_assoc($checkFBIdRes);
      return array('flag' => '1', 'entityId' => $userDet['entId'], 'profilePic' => $userDet['Profile_Pic_Url'],'status' => $userDet['status'], 'test' => $checkFBIdQry);
      } else {

      return array('flag' => '0', 'test' => $checkFBIdQry);
      }
      }
    
    /*
     * Method name: _getDeviceTypeName
     * Desc: Returns device name using device type id
     * Input: Device type id
     * Output:  Array with Device type name if true, else false
     */

    protected function _getDeviceTypeName($devTypeId) {

        $getDeviceNameQry = "select name from t_dev_type where dev_id = '" . $devTypeId . "'";
        $devNameRes = mysql_query($getDeviceNameQry, $this->db->conn);
        if (mysql_num_rows($devNameRes) > 0) {

            $devNameArr = mysql_fetch_assoc($devNameRes);
            return array('flag' => true, 'name' => $devNameArr['name']);
        } else {

            return array('flag' => false);
        }
    }

    /*
     * Method name: _verifyEmail
     * Desc: Checks email for uniqueness
     * Input: Email id to be checked
     * Output:  true if available else false
     */
    /*
      protected function _verifyEmail($email) {

      $verifyEmailQry = "select user_id from t_entity_details where Email = '" . $email . "'";
      $verifyEmailRes = mysql_query($verifyEmailQry, $this->db->conn);

      if (mysql_num_rows($verifyEmailRes) > 0) {
      return true;
      } else {
      return false;
      }
      }
     */
    /*
     * Method name: _getStatusMessage
     * Desc: Get details of an error from db
     * Input: Error number that need details
     * Output:  Returns an array with error details
     */

    protected function _getStatusMessage($errNo, $test_num) {

        $msg = new getErrorMsg($errNo);
        return array('errNum' => $msg->errId, 'errFlag' => $msg->errFlag, 'errMsg' => $msg->errMsg); //,'test'=>$test_num);
    }

    /*
     * Method name: revokeSessToken
     * Desc: Revokes a session token
     * Input: Object Id and Token
     * Output: 1 for Success and 0 for Failure
     */
    /*
      protected function _getSessDetails($token, $device_id) {

      $curr_date = time();
      $curr_gmt_date = gmdate('Y-m-d H:i:s', $curr_date);

      $getDetQry = "select  us.oid, us.expiry_gmt, us.device, us.type, us.sid,ed.First_Name,ed.Fb_Id from t_user_sessions us, t_entity_details ed where us.oid = ed.Entity_Id and us.token = '" . $token . "' and us.device = '" . $device_id . "'";
      $getDetRes = mysql_query($getDetQry, $this->db->conn);

      if (mysql_num_rows($getDetRes) > 0) {

      $sessDet = mysql_fetch_assoc($getDetRes);

      if ($sessDet['expiry_gmt'] > $curr_gmt_date)
      return array('flag' => '0', 'sid' => $sessDet['sid'], 'entityId' => $sessDet['oid'], 'deviceId' => $sessDet['device'], 'deviceType' => $sessDet['type'], 'firstName' => $sessDet['First_Name'], 'fbId' => $sessDet['Fb_Id']);
      else
      return array('flag' => '1');
      } else {
      return array('flag' => '2');
      }
      }
     */
    /*
     * Method name: _signupEntity
     * Desc: Signs up an entity
     * Input: Request data, unique id, token object
     * Output: returns array of output data if completed, else returns error message
     * extra :call from login ws
     */

    protected function _signupEntity($args, $unique_id, $token_obj) {

        $devTypeNameArr = $this->_getDeviceTypeName($args['ent_device_type']);

 		if($args['ent_dob']=="")
            {
            $dob = '1990-01-01';
            }
            else{
                $dob=$args['ent_dob'];
            }
         
            $currentDate = date("Y-m-d");
            $age =  $currentDate-$dob; 

        if (!$devTypeNameArr['flag']) {

            return $this->_getStatusMessage(5, 104);
        }

        $curr_time = time();
        $curr_gmt_date = gmdate('Y-m-d H:i:s', $curr_time);

        $signupEntityQry = "insert into t_entity(Unique_Identifier, Password, Create_Dt, Last_Active_Dt_Time, Device_Type, Device_Id, authType)
                        values('" . $unique_id . "', '" . $args['ent_password'] . "', '" . $curr_gmt_date . "', '" . $curr_gmt_date . "', '" . $args['ent_device_type'] . "', '" . $args['ent_dev_id'] . "', '" . $args['ent_auth_type'] . "' ) ";
        mysql_query($signupEntityQry, $this->db->conn);
//        echo $signupEntityQry;
        $newEntityId = mysql_insert_id();

        if ($newEntityId > 0) {

            if ($args['ent_dob'] == '' || $args['ent_dob'] == '0000-00-00')// || $args['ent_dob'] == '0000-00-00'
                $args['ent_dob'] = '1990-01-01';
               if($args['ent_profile_pic'] =='')
               {
               $profile =$this->host."/pics/default.png";
               }
               else{
               $profile =$args['ent_profile_pic'];
               }

            $insertAdditionalDetailsQry = "
                insert into t_entity_details(Entity_Id, Fb_Id, First_Name, Last_Name, Sex,Device_Type, pushtoken,Profile_Pic_Url,
               Current_Lat,Current_Long,DOB)
                values('" . $newEntityId . "', '" . $args['ent_fbid'] . "', '" . $args['ent_first_name'] . "', '" . $args['ent_last_name'] . "',  '" . $args['ent_sex'] . "',  '" . $args['ent_device_type'] . "', '" . $args['ent_push_token'] . "', '" .$profile  . "',
              '" . $args['ent_curr_lat'] . "', '" . $args['ent_curr_long'] . "',  '" . $args['ent_dob'] . "')";
            mysql_query($insertAdditionalDetailsQry, $this->db->conn); //Personal_Desc, '" . $args['ent_pers_desc'] . "',
//echo $insertAdditionalDetailsQry;

  $insertimageprofile = "
                insert into t_images(entity_id,image_url,index_id)values('" . $newEntityId . "', '" . $args['ent_profile_pic'] . "','0')";
            mysql_query($insertimageprofile, $this->db->conn); 

            if ($args['ent_sex'] == '1')
                $preferenceSex = 3;
            else
                $preferenceSex = 3;



            $args['ent_pref_lower_age'] = 18;


            $args['ent_pref_upper_age'] = 40;


            $args['ent_pref_radius'] = 100;

            $insertPreferencesQry = "insert into t_preferences(Entity_Id,Preference_Sex,Preference_lower_age,Preference_upper_age,Preference_radius) values('" . $newEntityId . "','" . $preferenceSex . "','" . $args['ent_pref_lower_age'] . "','" . $args['ent_pref_upper_age'] . "','" . $args['ent_pref_radius'] . "')";
            mysql_query($insertPreferencesQry, $this->db->conn);

            if ($args['ent_likes'] != '')
                $this->_insertLikes($newEntityId, $args['ent_likes']);

            $createSessArr = $token_obj->createSessToken($newEntityId, $devTypeNameArr['name'], $args['ent_dev_id'], $args['ent_push_token']);

            $errMsgArr = $this->_getStatusMessage(3, 105);
            return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'token' => $createSessArr['Token'], 'expiryLocal' => $createSessArr['Expity_local'], 'expiryGMT' => $createSessArr['Expity_GMT'], 'flag' => $createSessArr['Flag'],'profilePic'=>$args['ent_profile_pic'],'age'=>$age,'status'=>'' );
        } else {

            return $this->_getStatusMessage(7, 106);
        }
    }

    /*
     * Method name: _entitySocialLogin
     * Desc: Checks the entity social login cred's
     * Input: Request data, unique id, token object
     * Output: returns array of output data if completed, else returns error message
     * extra: call ws from login
     */

    protected function _entitySocialLogin($args, $unique_id, $token_obj) {
		 if($args['ent_dob']=="")
            {
            $dob = '1990-01-01';
            }
            else{
                $dob=$args['ent_dob'];
            }
         
            $currentDate = date("Y-m-d");
            $age =  $currentDate-$dob; 

        $checkUserFbId = $this->_checkEntityLogin($unique_id, $args['ent_auth_type']);

        if ($checkUserFbId['flag'] == '1') {

            $checkUserSessionQry = "select sid, token, expiry_gmt from t_user_sessions where oid = '" . $checkUserFbId['entityId'] . "' and device = '" . $args['ent_dev_id'] . "'";
            $checkUserSessionRes = mysql_query($checkUserSessionQry, $this->db->conn);
            if (mysql_num_rows($checkUserSessionRes) >= 0) {
                //if ($args['ent_likes'] != '')
                // $like_arr_output = $this->setLikes($args, $checkUserFbId['entityId']);
                $this->_updateActiveDateTime($checkUserFbId['entityId']);
                $this->_updateEntityDetails($args, $checkUserFbId['entityId']);
                // $updateArr = $token_obj->updateSessToken($checkUserFbId['entityId'], $args['ent_dev_id'], $args['ent_push_token']);

                $errMsgArr = $this->_getStatusMessage(2, 107);
                return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'token' => $updateArr['Token'], 'expiryLocal' => $updateArr['Expiry_local'], 'expiryGMT' => $updateArr['Expiry_GMT'], 'profilePic' => $checkUserFbId['profilePic'],'status' => $checkUserFbId['status'], 'flag' => $updateArr['Flag'],'age'=>$age);
            } else {

                $this->_updateActiveDateTime($checkUserFbId['entityId']);
                $devTypeNameArr = $this->_getDeviceTypeName($args['ent_device_type']);
                if (!$devTypeNameArr['flag']) {

                    return $this->_getStatusMessage(5, 108);
                } else {

                    if ($args['ent_likes'] != '')
                        $like_arr_output = $this->setLikes($args, $checkUserFbId['entityId']);

                    $createSessArr = $token_obj->createSessToken($checkUserFbId['entityId'], $devTypeNameArr['name'], $args['ent_dev_id'], $args['ent_push_token']);
                    $errMsgArr = $this->_getStatusMessage(2, 109);
                    return array('errNum' => $errMsgArr['errNum'], 'errFlag' => $errMsgArr['errFlag'], 'errMsg' => $errMsgArr['errMsg'], 'token' => $createSessArr['Token'], 'expiryLocal' => $createSessArr['Expity_local'], 'expiryGMT' => $createSessArr['Expity_GMT'], 'profilePic' => $checkUserFbId['profilePic'],'status' => $checkUserFbId['status'], 'flag' => $createSessArr['Flag']);
                }
            }
        } else {

            $signupArr = $this->_signupEntity($args, $unique_id, $token_obj);
            return $signupArr;
        }
    }

    /*
     * Method name: _updateEntityDetails
     * Desc: Updates entity details
     * Input: Request data, entity_id
     * Output: nothing
     */
// Profile_Pic_Url='" . $args['ent_profile_pic'] . "', 
    protected function _updateEntityDetails($args, $entity_id) {

        if ($args['ent_dob'] == '' || $args['ent_dob'] == '0000-00-00')
            $args['ent_dob'] = '1990-01-01';

        $updateAdditionalDetailsQry = "
                 update t_entity_details
                        set
                        Fb_Id = '" . $args['ent_fbid'] . "',
                       
                        First_Name = '" . $args['ent_first_name'] . "',
                        Last_Name = '" . $args['ent_last_name'] . "',
                        
                        Sex = '" . $args['ent_sex'] . "',
                        Device_Type='" . $args['ent_device_type'] . "', 
                       
                            
                           
                        pushtoken='" . $args['ent_push_token'] . "',    
                        
                       
                        Current_Lat =  '" . $args['ent_curr_lat'] . "',
                        Current_Long =  '" . $args['ent_curr_long'] . "',
                        
                        DOB =  '" . $args['ent_dob'] . "'
                        where
                        Entity_Id = '" . $entity_id . "'";
        mysql_query($updateAdditionalDetailsQry, $this->db->conn);
    }

    /*
     * Method name: _insertLikes
     * Desc: Inserts likes for a user
     * Input: Request data, entity_id
     * Output: 1 - success, 0 - failure
     */
    /*
      protected function _insertLikes_old($entity_id, $like_string) {

      $likes_arr = array_filter(array_unique(explode(',', $like_string)));
      $insert_count = 0;
      foreach ($likes_arr as $value) {

      $insertLikeQry = "insert into t_user_likes(like_id,entity_id) values('" . $value . "','" . $entity_id . "')";
      $insertLikeRes = mysql_query($insertLikeQry, $this->db->conn);
      if ($insertLikeRes) {
      $insert_count++;
      }
      }
      if (count($likes_arr) == $insert_count) {
      return 1;
      } else {
      return 0;
      }
      }
     */
    /*
     * Method name: _getEntityId
     * Desc: Gives entity id for the facebook id
     * Input: Request data, entity_id
     * Output: entity id for success or error array
     */

    protected function _getEntityId($fbid) {

        $getEntityIdQry = "select Entity_Id,status from t_entity where Unique_Identifier = '" . $fbid . "'";
        $getEntityIdRes = mysql_query($getEntityIdQry, $this->db->conn);
        if (mysql_num_rows($getEntityIdRes) > 0) {

            $entIdRow = mysql_fetch_assoc($getEntityIdRes);

            if ($entIdRow['status'] != '1')
                return $this->_getStatusMessage(49, 110);
            else
                return $entIdRow['Entity_Id'];
        } else {
            return $this->_getStatusMessage(38, 111);
        }
    }

    protected function _getEntityIddetail($entitydid) {

        $getEntityIdQry = "select * from t_entity_details where Entity_Id = '" . $entitydid . "'";
        $getEntityIdRes = mysql_query($getEntityIdQry, $this->db->conn);
        if (mysql_num_rows($getEntityIdRes) > 0) {

            $entIdRow = mysql_fetch_assoc($getEntityIdRes);


            return $entIdRow;
        }
    }

    /*
     * Method name: _getEntityDet
     * Desc: Gives facebook id for entity id 
     * Input: Request data, entity_id
     * Output: entity details for success or error array
     */

    protected function _getEntityDet($eid) {

        $getEntityDetQry = "select Fb_Id,Profile_Pic_Url,First_Name from t_entity_details where Entity_Id = '" . $eid . "'";
        $getEntityDetRes = mysql_query($getEntityDetQry, $this->db->conn);

        if (mysql_num_rows($getEntityDetRes) > 0) {

            return mysql_fetch_assoc($getEntityDetRes);
        } else {
            return false;
        }
    }

    /*
     * Method name: _sendPush
     * Desc: Divides the tokens according to device type and sends a push accordingly
     * Input: Request data, entity_id
     * Output: 1 - success, 0 - failure
     */

    protected function _sendPush($senderId, $recEntityArr, $message, $notifType, $sname, $sFid, $datetime, $msg_id = NULL, $msg_type = NULL) {

        $entity_string = '';
        $aplTokenArr = array();
        $andiTokenArr = array();
        $return_arr = array();

        foreach ($recEntityArr as $entity) {

            $insertNotesQry = "insert into t_notifications(notif_type,sender,reciever,message,notif_dt) values('" . $notifType . "','" . $senderId . "','" . $entity . "','" . $message . "','" . $datetime . "')";
            mysql_query($insertNotesQry, $this->db->conn);
            $ins_id = mysql_insert_id();

            if ($ins_id > 0)
                $return_arr[] = array($entity => $ins_id);

            $entity_string = $entity . ',';
        }

        $entity_comma = rtrim($entity_string, ',');


        $entity_comma;
//echo '--'.$entity_comma.'--';
        //$getUserDevTypeQry = "select type,push_token from t_user_sessions where oid in (" . $entity_comma . ") and loggedIn = '1'";
        $getUserDevTypeQry = "select Device_Type,pushtoken from t_entity_details where Entity_Id in (" . $entity_comma . ") ";

        $getUserDevTypeRes = mysql_query($getUserDevTypeQry, $this->db->conn);

        if (mysql_num_rows($getUserDevTypeRes) > 0) {

            while ($tokenArr = mysql_fetch_assoc($getUserDevTypeRes)) {

                if ($tokenArr['Device_Type'] == 1)
                    $aplTokenArr[] = $tokenArr['pushtoken'];

                else if ($tokenArr['Device_Type'] == 2)
                    $andiTokenArr[] = $tokenArr['pushtoken'];

                // print_R($aplTokenArr);
                // print_R($andiTokenArr);
            }

            $aplTokenArr = array_values(array_filter(array_unique($aplTokenArr)));
            $andiTokenArr = array_values(array_filter(array_unique($andiTokenArr)));
//            print_r($andiTokenArr);
            if (count($aplTokenArr) > 0)
                $aplResponse = $this->_sendApplePush($aplTokenArr, $message, $notifType, $sFid, $sname, $datetime, $msg_id, $msg_type);


            if (count($andiTokenArr) > 0)
                $andiResponse = $this->_sendAndroidPush($andiTokenArr, $message, $notifType, $sFid, $sname, $datetime, $msg_id, $msg_type);

//            echo '---';
//print_r($aplResponse);
//echo '---';
//print_r($andiResponse);
//echo '---';
//print_r($aplTokenArr);
//echo '---';
//print_r($andiTokenArr);
//echo '---';

            if ($aplResponse['errorNo'] != '')
                $errNum = $aplResponse['errorNo'];
            else if ($andiResponse['errorNo'] != '')
                $errNum = $andiResponse['errorNo'];
            else
                $errNum = 46;

            return array('insEnt' => $return_arr, 'errNum' => $errNum);
        } else {
            return array('insEnt' => $return_arr, 'errNum' => 45); //means push not sent
        }
    }

    protected function _sendApplePush($tokenArr, $message, $notifType, $sFid, $sname, $datetime, $msg_id = NULL, $msg_type = NULL) {

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->ios_cert_path);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->ios_cert_pwd);

        //$apns_fp = stream_socket_client($this->ios_cert_server, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        $apns_fp = @stream_socket_client($this->ios_cert_server, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        //$apns_fp= @stream_socket_client($this->sandboxSsl, $err,
        //		$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $this->ctx);	




        if ($apns_fp) {

            if ($msg_type == NULL)
                $msg_type = 0;

            if ($msg_id == NULL)
                $msg_id = 0;

            $body['aps'] = array(
                //'badge' => $this->badgeCount,
                'alert' => $message,
                'nt' => $notifType,
                'sFid' => $sFid,
                'sname' => $sname,
                'dt' => $datetime,
                'mt' => $msg_type,
                'mid' => $msg_id
            );

            $payload = json_encode($body);

            $msg = '';
            foreach ($tokenArr as $token) {
                $msg .= chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
            }

            $result = fwrite($apns_fp, $msg, strlen($msg));


            if (!$result)
                return array('errorNo' => 46);
            else
                return array('errorNo' => 44);
        } else {
            return array('errorNo' => 30);
        }
    }

    protected function _sendAndroidPush($tokenArr, $message, $notifType, $sFid, $sname, $datetime, $msg_id = NULL, $msg_type = NULL) {

//        print_r($tokenArr);


        if ($msg_type == NULL)
            $msg_type = 0;

        if ($msg_id == NULL)
            $msg_id = 0;

        $data = array("payload" => $message, 'action' => $notifType, 'sname' => $sname, 'dt' => $datetime, 'mt' => $msg_type, 'mid' => $msg_id, 'sfid' => $sFid); // action defines whether any action should take after recieving the push

        $fields = array(
            'registration_ids' => $tokenArr,
            'data' => $data,
        );

        $headers = array(
            'Authorization: key=' . $this->androidApiKey,
            'Content-Type: application/json'
        );
// Open connection
        $ch = curl_init();

// Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $this->androidUrl);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

// Execute post
        $result = curl_exec($ch);
        //echo $result;

        curl_close($ch);
//        echo 'Result from google:' . $result . '---';
        $res_dec = json_decode($result);

        if ($res_dec->success >= 1)
            return array('errorNo' => 44, 'result' => $result);
        else
            return array('errorNo' => 46, 'result' => $result);
    }

    protected function _updateActiveDateTime($entId) {

        $curr_date = time();
        $curr_gmt_date = gmdate('Y-m-d H:i:s', $curr_date);

        $updateQry = "update t_entity set Last_Active_Dt_Time = '" . $curr_gmt_date . "' where Entity_Id = '" . $entId . "'";
        mysql_query($updateQry, $this->db->conn);

        if (mysql_affected_rows() > 0)
            return true;
        else
            return false;
    }

}

if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {

    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {

    $API = new MyAPI($_SERVER['REQUEST_URI'], $_REQUEST, $_SERVER['HTTP_ORIGIN']);

    echo $API->processAPI();
} catch (Exception $e) {

    echo json_encode(Array('error' => $e->getMessage()));
}





/*
 * Method name: updateEntity
 * Desc: Updating entity details
 * Input: Request data
 * Output:  Array data
 */

//    protected function updateEntity($args) {
//
//        $returned = $this->_validate_token($args['ent_sess_token'], $args['ent_dev_id']);
//        if (is_array($returned)) {
//            return $returned;
//        }
//
//        $updateEntityQry = "
//                    update entity_details 
//                    set 
//                    Profile_Pic_Url = '" . $args['ent_prof_pic_url'] . "',
//                    Pic_2 = '" . $args['ent_pic_2'] . "',
//                    Pic_3 = '" . $args['ent_pic_3'] . "',
//                    Pic_4 = '" . $args['ent_pic_4'] . "',
//                    Pic_5 = '" . $args['ent_pic_5'] . "',
//                    City = '" . $args['ent_city'] . "',
//                    Country = '" . $args['ent_country'] . "',
//                    Current_Lat = '" . $args['ent_curr_lat'] . "',
//                    Current_Long = '" . $args['ent_curr_long'] . "',
//                    TagLine = '" . $args['ent_tag_line'] . "',
//                    Personal_Desc = '" . $args['ent_pers_desc'] . "',
//                    DOB = '" . $args['ent_dob'] . "'
//                    where
//                    Entity_Id = '" . $this->User['entityId'] . "'";
//
//        $updateEntityRes = mysql_query($updateEntityQry, $this->db->conn);
//
//        if (mysql_affected_rows() > 0) {
//
//            $updatePrefQry = "update preferences set ";
//            $updateCheck = 0;
//            if (isset($args['ent_pref_sex']) && $args['ent_pref_sex'] != '') {
//                $updatePrefQry .= "Preference_Sex = '" . $args['ent_pref_sex'] . "', ";
//                $updateCheck++;
//            }
//            if (isset($args['ent_pref_lower_age']) && $args['ent_pref_lower_age'] != '') {
//                $updatePrefQry .= "Preference_lower_age = '" . $args['ent_pref_lower_age'] . "', ";
//                $updateCheck++;
//            }
//            if (isset($args['ent_pref_upper_age']) && $args['ent_pref_upper_age'] != '') {
//                $updatePrefQry .= "Preference_upper_age = '" . $args['ent_pref_upper_age'] . "', ";
//                $updateCheck++;
//            }
//            if (isset($args['ent_pref_radius']) && $args['ent_pref_radius'] != '') {
//                $updatePrefQry .= "Preference_radius = '" . $args['ent_pref_radius'] . "', ";
//                $updateCheck++;
//            }
//
//            if ($updateCheck > 0) {
//                $updatePref = rtrim($updatePrefQry, ', ');
//                $updatePrefQry = $updatePref . " where Entity_Id = '" . $this->User['entityId'] . "'";
//                mysql_query($updatePrefQry, $this->db->conn);
//            }
//
//            return $this->_getStatusMessage(10,32);
//        } else {
//            if ($updateEntityRes) {
//
//                return $this->_getStatusMessage(11,33);
//            } else {
//
//                return $this->_getStatusMessage(12,34);
//            }
//        }
//    }
?>