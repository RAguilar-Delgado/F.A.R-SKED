<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{

	public function login_save(){
		$this->load->model('Login_model', 'login');
		$requiredFields = ['UserName', 'Password'];

		$post = [];
		foreach($requiredFields as $field){
			$data = trim($this->input->post($field));

			if(!$data){
				die(json_encode(['error' => 'All fields are required!']));
			}
			$post[$field] = $data;
		}

		die(json_encode($this->login->login_save($post)));
	}
}
