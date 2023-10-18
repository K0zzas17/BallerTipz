<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class my_account extends CI_Controller {

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
		$this->load->model('file_model');
		$this->load->helper('form');
		$this->load->helper('url');
        $this->load->view('template/header');

		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			redirect('login', $data); //if user has not login redirect to login page
			
		} else {
			$data['profile_picture'] = $this->file_model->get_profile_picture();
			$username = $this->session->userdata('username');
			$data['valid'] = $this->user_model->get_validation($username);
			$data['token'] = $this->user_model->get_token($username);
			$this->load->view('my_account', $data);
			$this->load->view('template/footer');
		}
	}


	public function update_details()
	{
		$this->load->model('user_model'); //load user model
		$data['update'] = "";		
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view("update_profile", $data);
		$this->load->view("template/footer");
	
	}


	public function get_questions() 
	{
		//Get questions by retrieving from db based on username = author.
		$this->load->model('user_model');		//load user model
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');

	}

	public function get_answers() 
	{
		$this->load->model('user_model');		//load user model
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
	}
	

}
