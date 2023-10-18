<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class Question_model extends CI_Model{

    //posts question by adding question info to database
    public function post_question($question_title, $question_author, $question_text) {
        $question_date = date('Y-m-d');	 //Get date question is posted

        if ($question_title == '' || $question_author == '' || $question_text == '') {
            return false;
        } 

        $user_data = array(
			"question_title" => $question_title,
			"question_author" => $question_author,
			"question_text" => $question_text,
			"question_date" => $question_date,
            "ratings" => 0
		);

		$this->db->insert('questions', $user_data);
		
        //In future, implement it so that it auto selects the new question in discussion

        return true;
	}


    
}
