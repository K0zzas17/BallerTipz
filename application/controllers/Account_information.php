<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class account_information extends CI_Controller {

	public function index()
	{
        $this->load->model('file_model');
        $this->load->model('user_model');
		$data['error']= "";
        $data['user_info'] = $this->user_model->get_user_details();
		$this->load->helper('form');
		$this->load->helper('url');
        $this->load->view('template/header');

		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			redirect('login', $data); //if user has not login redirect to login page
			
		} else {
			$data['profile_picture'] = $this->file_model->get_profile_picture();
				
			$this->load->view('account_information', $data);
			$this->load->view('template/footer');
		}
	}

}