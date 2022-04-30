<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller{
	 
	public function home_page(){
		$this->load->model('Auth_model', 'auth');
		$this->load->model('Login_model', 'login');
		$this->auth->check_login();
		

		$data = [
			'pageData' => [
				'test' => $this->login->get_users()
			]
		];

		json_encode($data);
		$data['pageData'] = json_encode($data['pageData']);
		$this->loadPage(array('page'=>'Home/home_page','title'=>'Dep SKED - home','footer'=>true,'statusBar'=>true,'data'=>$data));
	}

	public function test_home_page(){
		$this->load->model('Auth_model', 'auth');
		$this->auth->check_login();
		

		$data = [
			'pageData' => [
				'test' => ''
			]
		];

		json_encode($data);
		$data['pageData'] = json_encode($data['pageData']);
		$this->loadPage(array('page'=>'Home/test_home_page','title'=>'Dep SKED - home','footer'=>true,'statusBar'=>true,'data'=>$data));

	}
}
