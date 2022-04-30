<?php defined('BASEPATH') or die('No direct script access.');

class Semester_model extends CI_Model{
    public function __construct(){
        parent::__construct();
	}

	public function get_semester_time_block_schedules(){
		$query = $this->db
		->select('s.*')
		->from('tblSemesterTimeBlockSchedules s')
		->get();

		return $query->result_array();
	}

	public function insert_test_time_schedule_block(){

		/*$json = [
			'MWF' => [
				['STime' => '7:30am', 'ETime' => '8:20am'],
				['STime' => '8:40am', 'ETime' => '9:30am'],
				['STime' => '9:45am', 'ETime' => '10:05am', 'ChapelBreak' => true],
				['STime' => '10:20am', 'ETime' => '11:10am'],
				['STime' => '11:30am', 'ETime' => '12:20pm'],
				['STime' => '12:40pm', 'ETime' => '1:30am'],
				['STime' => '1:50pm', 'ETime' => '2:40pm'],
				['STime' => '3:00pm', 'ETime' => '3:50pm'],
				['STime' => '4:10pm', 'ETime' => '5:00pm'],
				['STime' => '5:20pm', 'ETime' => '6:10pm'],
				['STime' => '6:30pm', 'ETime' => '7:20pm'],
				['STime' => '7:40pm', 'ETime' => '8:30pm'],
				['STime' => '8:50pm', 'ETime' => '9:40pm']
			],
			'TTH' => [
				['STime' => '8:15am', 'ETime' => '9:30am'],
				['STime' => '9:45am', 'ETime' => '10:05am', 'ChapelBreak' => true],
				['STime' => '10:20am', 'ETime' => '11:35am'],
				['STime' => '11:55am', 'ETime' => '1:10pm'],
				['STime' => '1:30pm', 'ETime' => '2:45pm'],
				['STime' => '3:05pm', 'ETime' => '4:20pm'],
				['STime' => '4:40pm', 'ETime' => '5:55pm'],
				['STime' => '6:15pm', 'ETime' => '7:30'],
				['STime' => '7:50am', 'ETime' => '9:05']
			]
		];

		$data = [
			'TimeBlockScheduleID' => 1,
			'Name' => 'Demo Time Block Schedule',
			'TimeBlockJson' => json_encode($json)
		];

		$this->db->insert('tblTimeBlockSchedules',$data);*/
	}
}