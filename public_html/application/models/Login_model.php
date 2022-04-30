<?php defined('BASEPATH') or die('No direct script access.');

class Login_Model extends CI_Model{
    public function __construct(){
        parent::__construct();
	}

	public function test(){
		$query = $this->db
		->select('u.*')
		->from('tblUsers u')
		->get();

		return $query->result_array();
	}

	public function get_users(){
		$query = $this->db
		->select('u.*')
		->from('tblUsers u')
		->get();

		return $query->result_array();
	}
	public function create_user_save($data){
		$username = $data['Username'];
		$password = password_hash($data['Password'], PASSWORD_DEFAULT);

		$query = $this->db
		->select('u.Username')
		->from('tblUsers u')
		->where('u.Username', $username)
		->get();

		if(count($query->result_array()) > 0){
			return ['error' => 2, 'errorMsg' => 'Username already exists!'];
		}
		$this->db->trans_start();
		$this->db->insert('tblUsers', ['Username' => $username, 'Password' => $password]);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
        	return ['error' => 3, 'errorMsg' => 'Transaction failed!'];
		}	

		return ['error' => 0];	
	}

	public function login_save($data){
		$username = $data['Username'];
		$password = $data['Password'];

		$query = $this->db
		->select('u.UserID, u.Password')
		->from('tblUsers u')
		->where('u.Username', $username)
		->limit(1)
		->get();

		$result = $query->first_row();

		if(password_verify($password, $result->Password)){
			$this->session->set_userdata(['userid' => $result->UserID]);
		} else {
			return ['error' => 1, 'errorMsg' => 'Password or Username did not exist/match!'];
		}
		return ['error' => 0];
	}
}