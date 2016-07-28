<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users extends CI_Controller {

    function __construct() {
        parent::__construct();


        if ($this->session->userdata('login') == FALSE) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('data_model');
        $this->load->library('session');
        $this->load->library('pagination');
    }

    public function index() {
        $this->load->model('data_model');
        $data['users_list'] = $this->data_model->users_list();
        $this->load->view('header_new');
        $this->load->view('user', $data);
        $this->load->view('footer_new');
    }

    public function search() {
        $string = $_GET['q'];

        $this->load->model('data_model');
        $data['users_list'] = $this->data_model->users_list_search($string);
        $this->load->view('header_new');
        $this->load->view('user', $data);
        $this->load->view('footer_new');
    }

    public function question() {
        $this->load->model('data_model');
        $data['question_list'] = $this->data_model->question_list();
        $this->load->view('header_new');
        $this->load->view('new_question', $data);
        $this->load->view('footer_new');
        
       
    }

    public function chekin_location() {
        $this->load->model('data_model');
        $data['question_list'] = $this->data_model->chekin_location();
        $this->load->view('header_new');
        $this->load->view('new_location_view', $data);
        $this->load->view('footer_new');
    }

    public function chekin_location_edit() {

        $location_id = $this->input->post('location');
        $deleteid = $this->input->post('delete');

        $this->load->model('data_model');

      if ($deleteid == "") {
            $data['location_detail'] = $this->data_model->chekin_location_id($location_id);


            $this->load->view('header_new');
            $this->load->view('new_location_edit', $data);
            $this->load->view('footer_new');
        } else {


            $data = $this->data_model->location_delete($deleteid);


            if ($data == 1) {
                $this->session->set_flashdata('message', 'Delete Location Successfully');
                redirect('users/chekin_location');
            } else {
                $this->session->set_flashdata('message', 'Delete Location Not Successfull');
                redirect('users/chekin_location');
            }
        }
    }

    /*
     * edit question call from view question and edit question 
     * when view_id blank it run  question edit and not empty that time it run option
     */

    public function edit_question() {
        $q_id = $this->input->post('question');

        $view_id = $this->input->post('view_id');

        $delete_id = $this->input->post('delete');




        if ($view_id != '') {

            $this->load->model('data_model');
            $data['option_list'] = $this->data_model->option_list($view_id);
            if (empty($data)) {
                $data['option_list'] = "tere is no option";
            }
            $data['view_id'] = $view_id;


            $this->load->view('header_new');
            $this->load->view('new_option', $data);
            $this->load->view('footer_new');
        } else if ($delete_id != '') {


            $this->load->model('data_model');
// echo $delete_id;
            $data1['que_delete'] = $this->data_model->question_delete($delete_id);


            $data['question_list'] = $this->data_model->question_list();

            $this->load->view('header_new');
            $this->load->view('new_question', $data);
            $this->load->view('footer_new');
        } else {

            $this->load->model('data_model');
            $data['question_edit'] = $this->data_model->question_edit($q_id);



            $this->load->view('header_new');
            $this->load->view('new_question_edit', $data);
            $this->load->view('footer_new');
        }
    }

    public function edit_question1($view_id) {

        $this->load->model('data_model');
        $data['option_list'] = $this->data_model->option_list($view_id);
//print_R($data);


        $this->load->view('header_new');
        $this->load->view('new_option', $data);
        $this->load->view('footer_new');
    }

    public function question_add() {

        $this->load->view('header_new');
        $this->load->view('new_question_add');
        $this->load->view('footer_new');
    }

    /*
     * this method for edit option means display option par partucular question
     */

    public function edit_option() {
        $view_id = $this->input->post('option_id');
        $delete = $this->input->post('delete_id');
        $q_id = $this->input->post('q_id');

        if ($delete == '') {

            $this->load->model('data_model');
            $data['option_edit'] = $this->data_model->option_edit($view_id);



            $this->load->view('header_new');
            $this->load->view('new_option_edit', $data);
            $this->load->view('footer_new');
        } else {
            $this->load->model('data_model');
            $data1['option_delete'] = $this->data_model->option_delete($delete);
            $data['option_list'] = $this->data_model->option_list($q_id);
            $this->load->view('header_new');
            $this->load->view('new_option', $data);
            $this->load->view('footer_new');
        }
    }

    /* method Name:option_add
     * desc: this method just load view option_add screen for insert option for paticular question
     */

    public function option_add($q_id) {
        $data['q_id'] = $q_id;

        $this->load->view('header_new');
        $this->load->view('new_option_add', $data);
        $this->load->view('footer_new');
    }

    /* method Name:option_insert
     * desc: this method call from option_add view with this insert option in database
     */

    public function option_insert() {

        $q_id = $this->input->post('questio_id');
        $option = $this->input->post('option');
// echo $q_id.$option;

        $this->load->model('data_model');
        $data['option_edit'] = $this->data_model->insert_option($q_id, $option);
        $que['q_id'] = $q_id;
        $this->load->view('header_new');
        $this->load->view('new_option_add', $que);
        $this->load->view('footer_new');
    }

    public function question_insert() {


//echo $q_id.$option;
        $question = $this->input->post('question');
        $option1 = $this->input->post('option_a');
        $option2 = $this->input->post('option_b');
        $option3 = $this->input->post('option_c');
        $option4 = $this->input->post('option_d');

        $options = array('option1' => $option1, 'option2' => $option2, 'option3' => $option3, 'option4' => $option4);
        $data = $this->data_model->insert_answer($question, $options);


        if ($data == 1) {
            $this->session->set_flashdata('message', "<font color=\"green\">Question Added Sucessfully.</font>");
            redirect('users/question_add');
        } else {

            $this->session->set_flashdata('message', "<font color=\"red\">Question Added Not Sucessfully.</font>");
            redirect('users/question_add');
        }
    }

    /* method Name:option_insert
     * desc: tthis method for update question 
     */

    public function update_question() {

        $quistion = $this->input->post('questionlist');
        $q_id = $this->input->post('question');

        $this->load->model('data_model');
        $data = $this->data_model->question_update($quistion, $q_id);

        redirect("users/question");
    }

    /*
     * this method update option for quetion
     */

    public function update_option() {

        $option_id = $this->input->post('question');
        $optionlist = $this->input->post('optionlist');
        $optionid = $this->input->post('option_id');

        $this->load->model('data_model');
        $data = $this->data_model->option_update($option_id, $optionlist);
        $this->edit_question1($this->input->post('option_id'));
//redirect('users/edit_question');
    }

    public function location() {



        $this->load->view('header_new');
        $this->load->view('new_location');
        $this->load->view('footer_new');
    }

    public function insert_location() {
        $this->load->library('form_validation');

        $loc_name = $this->input->post('location');
        $loc_lat = $this->input->post('lat1');
        $loc_long = $this->input->post('lon1');
        $address = $this->input->post('address');
        $this->load->model('data_model');
        $data = $this->data_model->location_add($loc_name, $loc_lat, $loc_long, $address);
        if ($data == 1) {
            $this->session->set_flashdata('message', 'Add Location Successfully');
            redirect('users/location');
        } else {
            $this->session->set_flashdata('message', 'add Location Not Successfull');
            redirect('users/location');
        }
    }

    public function update_location() {
        $this->load->library('form_validation');

        $chekin_id = $this->input->post('id');
        $loc_name = $this->input->post('location');
        $loc_lat = $this->input->post('lat1');
        $loc_long = $this->input->post('lon1');
        $address = $this->input->post('address');
        $this->load->model('data_model');



        if ($deleteid == '') {

            $data = $this->data_model->location_update($chekin_id, $loc_name, $loc_lat, $loc_long, $address);
            if ($data == 1) {
                $this->session->set_flashdata('message', 'Update Location Successfully');
                redirect('users/chekin_location');
            } else {
                $this->session->set_flashdata('message', 'Update Location Not Successfull');
                redirect('users/chekin_location');
            }
        }
    }

}
