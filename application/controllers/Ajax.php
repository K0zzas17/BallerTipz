<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ajax extends CI_Controller {
    public function fatch()
    {
		$this->load->model('file_model'); // load file_model 
        $output = '';
        $query = '';
        if($this->input->get('query')){ 
            $query = $this->input->get('query'); // get search query send from ajax search form
        }
        $data = $this->file_model->fetch_data($query); //send query to file_model and put result to $data
            if(!$data == null){
                echo json_encode ($data->result()); //send result back
            }else{
                echo  ""; // no result found
            }
    }

    public function search_questions() 
    {
        $this->load->model('user_model');
        $query = '';
        $output = '';

        if($this->input->get('query')){ 
            $query = $this->input->get('query'); // get search query send from ajax search form
        }

        $result = $this->user_model->get_questions_search($query); //send query to user_model and put result to $result
            if(!$result == null) {
                echo json_encode($result->result()); //send result back
            }else{
                echo  ""; // no result found
            }
    }
}

?>