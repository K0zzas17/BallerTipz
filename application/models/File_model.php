<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class File_model extends CI_Model{

    // upload file
    public function upload($filename, $path, $username){

        $data = array(
            'filename' => $filename,
            'path' => $path,
            'username' => $username
        );
        $query = $this->db->insert('files', $data);

    }

    public function upload_profile_picture($filename, $path, $username){

        $data = array(
            'filename' => $filename,
            'path' => $path,
            'username' => $username
        );
        $this->db->where('username', $username);
        $result = $this->db->get('profile_pictures');
        if ($result->num_rows() == 0) {
            $query = $this->db->insert('profile_pictures', $data);
        } else {
            $query = $this->db->replace('profile_pictures', $data);
        }
    }

    public function get_profile_picture() {
        $this->db->select('filename');
        $this->db->where('username', $this->session->userdata('username'));
        $query_data = array();
        $query =  $this->db->get('profile_pictures');
        if ($query->num_rows() == 0) {
            return false;
        } elseif ($query->num_rows() == 1) {
            foreach ($query->result() as $tuple) {
				$query_data = $tuple;
            }
            return $query_data;
        }
    }

    function fetch_data($query)
    {
        if($query == '')
        {
            return null;
        }else{
            $this->db->select("*");
            $this->db->from("files");
            $this->db->like('filename', $query);
            $this->db->or_like('username', $query);
            $this->db->order_by('filename', 'DESC');
            return $this->db->get();
        }
    }
}
