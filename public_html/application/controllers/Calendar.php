<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends MY_Controller{
	 
	public function calendar_page(){
		$this->load->model('Calendar_model', 'cal');
		$this->load->model('Auth_model', 'auth');
		$this->auth->check_login();

		$data = [
			'pageData' => [
				'semesterSelect' => $this->cal->get_semester_select(),
				'professorSelect' => $this->cal->get_professor_select(),
				'buildingSelect' => $this->cal->get_building_select(),
				'roomSelect' => $this->cal->get_room_select()
			]
		];

		json_encode($data);
		$data['pageData'] = json_encode($data['pageData']);
		$this->loadPage(array('page'=>'Calendar/calendar_page','title'=>'Dep SKED - Calendar','footer'=>true,'statusBar'=>true,'data'=>$data));
	}

	public function get_calendar_data(){
		$this->load->model('Calendar_model', 'cal');
		die(json_encode($this->cal->get_calendar_data($this->input->get())));
	}
}
