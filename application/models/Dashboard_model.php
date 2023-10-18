<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	public function get_users($user, $ratings) {
        $user_srch = '';
        $order = ' ORDER BY q.`ratings` '.strtoupper($ratings);

        if ($user != '') {
            $user_srch = ' AND `username` LIKE "%'.$user.'%"';
        }

        $query = $this->db->query(
            'SELECT `username`, q.`question_title`, q.`ratings`, COUNT(`answer_id`) AS answers
            FROM `users` 
            LEFT JOIN `questions` AS q ON q.`question_author` = `users`.`username`
            LEFT JOIN `answers` ON `answers`.`question_id` = q.`question_id` 
            WHERE q.`question_title`IS NOT NULL'.$user_srch.' 
            GROUP BY `username`, q.`question_title`, q.`ratings`'.$order);

         return $query->result();
    }
}	
?>
