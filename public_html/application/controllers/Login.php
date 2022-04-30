<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller{
	 
	public function index(){
		$this->load->model('Login_model', 'login');
		$this->load->model('Auth_model', 'auth');
		if($this->auth->check_login()){
			//call another homepage view
		}

		$data = [
			'pageData' => [
				'test' => $this->login->test()
			]
		];
 
		json_encode($data);

		$data['pageData'] = json_encode($data['pageData']);
		$this->loadPage(array('page'=>'Login/login','title'=>'Dep SKED - Login','footer'=>true,'statusBar'=>true,'data'=>$data));
	}

	public function login_save(){
		$this->load->model('Login_model', 'login');
		$requiredFields = ['Username', 'Password'];

		$post = [];
		foreach($requiredFields as $field){
			$data = trim($this->input->post($field));

			if(!$data){
				die(json_encode(['error' => 0, 'errorMsg' => 'Missing all required fields!']));
			}
			$post[$field] = $data;
		}

		die(json_encode($this->login->login_save($post)));
	}

	public function create_user_save(){
		$this->load->model('Login_model', 'login');
		$requiredFields = ['Username', 'Password'];

		$post = [];
		foreach($requiredFields as $field){
			$data = trim($this->input->post($field));

			if(!$data){
				die(json_encode(['error' => 1, 'errorMsg' => 'Missing all required fields!']));
			}
			$post[$field] = $data;
		}

		die(json_encode($this->login->create_user_save($post)));
	}

	public function create_user_page(){
		$this->load->model('Login_model', 'login');
		$this->load->model('Auth_model', 'auth');

		$data = [
			'pageData' => [
			]
		];

		json_encode($data);

		$data['pageData'] = json_encode($data['pageData']);
		$this->loadPage(array('page'=>'Login/create_user_page','title'=>'Dep SKED - Create User','footer'=>true,'statusBar'=>true,'data'=>$data));
	}

}
