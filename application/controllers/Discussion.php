<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class discussion extends CI_Controller {
	
	public function index()
	{
        $this->load->model('user_model');	
        $data['db_questions']= $this->user_model->get_questions();
		$data['db_answers'] = $this->user_model->get_answers();
		$data['favourite_status'] = '';
		$data['active_question'] = '';
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$question_id = $this->input->post('question_id');
		$username = $this->session->userdata('username');
		
		$url = $_SERVER['REQUEST_URI']; //get end url portion of url
		if (strpos($url, '?active=')) { //checks if string contains query character '?'
		$active_q = parse_url($url, PHP_URL_QUERY);
		parse_str($active_q, $active); //finds variable in url, sets view variable $active_question as the url variable
		$data['active_question'] = $active['active'];
		}
		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			redirect('login', $data); //if user has not login redirect to login page
			
		} else {

			if ($this->user_model->check_question_favourite($question_id, $username)) {
				$data['favourite_status'] = array('Add favourite', $question_id);
			} else {
				$data['favourite_status'] = array('Remove favourite', $question_id);
			}

			$this->load->view('discussion', $data);
			$this->load->view('template/footer');
		}
	}

    public function get_questions() {
        $this->load->model('user_model');	
        $data['db_questions'] = $this->user_model->get_questions();
		$data['db_answers'] = $this->user_model->get_answers();
		$data['favourite_status'] = '';
		$data['error'] = '';

		//Retrieve URI to see if question was specified
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$question_id = $this->input->post('question_id');
		$username = $this->session->userdata('username');

		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			redirect('login', $data); //if user has not login redirect to login page
			
		} else {
			if ($this->user_model->check_question_favourite($question_id, $username)) {
				$data['favourite_status'] = array('Add favourite', $question_id);
			} else {
				$data['favourite_status'] = array('Remove favourite', $question_id);
			}
			$this->load->view('discussion', $data);
			$this->load->view('template/footer');
		}
    }

	public function post_answer() {
		$this->load->model('user_model');
		$data['db_questions']= $this->user_model->get_questions();
		$data['db_answers'] = $this->user_model->get_answers();	
		$data['favourite_status'] = '';
		$data['error'] = '';
		$data['active_question'] = $this->uri->segment(3);
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		
		$question_id = $this->input->post('question_id');
		$answer_author = $this->session->userdata('username');
		$username = $this->session->userdata('username');
		$answer_text = $this->input->post('answer'); //Get answer from textarea
		
		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			redirect('login', $data); //if user has not login redirect to login page
			
		} else {

			if ($this->user_model->check_question_favourite($question_id, $username)) {
				$data['favourite_status'] = array('Add favourite', $question_id);
			} else {
				$data['favourite_status'] = array('Remove favourite', $question_id);
			}
			
			if ($this->user_model->post_answer($question_id, $answer_author, $answer_text)) {
			redirect('discussion', $data);
			}
			else {
				$data['error'] = "Please input a valid answer";
				$this->load->view('discussion', $data);
			}
			$this->load->view('template/footer');
		}
	}

	public function add_question_favourite() {
		$this->load->model('user_model');	
		$data['db_questions']= $this->user_model->get_questions();
		$data['db_answers'] = $this->user_model->get_answers();
		$data['error'] = '';
		$data['favourite_status'] = '';
		$data['active_question'] = $this->uri->segment(3);
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');

		$question_id = $this->input->post('question_id');
		$username = $this->session->userdata('username');

		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			redirect('login', $data); //if user has not login redirect to login page
			
		} else {

			if ($this->user_model->toggle_question_favourite($question_id, $username)) {
				$data['favourite_status'] = array(true, $question_id);
			} else {
				$data['favourite_status'] = array(false, $question_id);
			}
			$data['active_question'] = $this->uri->segment(3);
			redirect('discussion', $data);

			$this->load->view('template/footer');
		}
	}
	
}
?>
