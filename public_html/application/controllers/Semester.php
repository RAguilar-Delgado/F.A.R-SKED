<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semester extends MY_Controller{
	 
	public function manage_semester_time_blocks_page(){
		$this->load->model('Semester_model', 'sem');
		$this->load->model('Auth_model', 'auth');
		$this->auth->check_login();

		$data = [
			'pageData' => [
				'schedules' => $this->sem->get_semester_time_block_schedules()
			]
		];

		json_encode($data);

		$data['pageData'] = json_encode($data['pageData']);
		$this->loadPage(array('page'=>'Semester/manage_semester_time_blocks_page','title'=>'Dep SKED - Semester Time Blocks','footer'=>true,'statusBar'=>true,'data'=>$data));
	}

	public function insert_test_time_schedule_block(){
		$this->load->model('Semester_model', 'sem');
		$this->sem->insert_test_time_schedule_block();
	}

}
