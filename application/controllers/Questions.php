<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$data['error'] = '';
        $this->load->view('template/header');

		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			if (get_cookie('remember')) { // check if user activate the "remember me" feature
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					$data['valid'] = $this->user_model->get_validation($username);
					$this->load->view('questions', $data); //if user already logined show main page
				}
			} else {
				$this->load->view('login', $data); //if user has not login ask user to login
			}
		} else {
			$this->load->view('questions', $data);
			$this->load->view('template/footer');
		}
	}

	public function post_question() {
		$this->load->model('question_model');
		$data['error'] = '';
		$data['selected_question'] = '';
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		
		$question_title = $this->input->post('question_title');
		$question_author = $this->session->userdata('username');
		$question_text = $this->input->post('question_text'); //Get answer from textarea
		
			if ($this->question_model->post_question($question_title, $question_author, $question_text)) {
				redirect('discussion', $data);
			}
			else {
				$data['error'] = "<div class=\"alert alert-danger text-center\" role=\"alert\"> Question could not be posted.</div> ";
				$this->load->view('questions', $data);
			}
			$this->load->view('template/footer');
	}
}
