<?php defined('BASEPATH') or die('No direct script access.');

class Calendar_model extends CI_Model{
    public function __construct(){
        parent::__construct();
	}

	public function get_test_time_block_schedule(){
		$return = [];

		$query = $this->db
		->select('tb.*')
		->from('tblTimeBlockSchedules tb')
		->where('tb.TimeBlockScheduleID', 1)
		->get();

		foreach($query->first_row('array') as $k => $v){
			if($k == 'TimeBlockJSON'){
				$v = json_decode($v);
			}

			$return[$k] = $v;
		}
		return $return;
	}

	public function get_semester_select(){
		$return = [];

		$query = $this->db
		->select('s.*')
		->from('tblSemesters s')
		->get();

		foreach($query->result() as $row){
			$return[$row->SemesterID] = ['val' => $row->SemesterID, 'text' => $row->Semester];
		}

		return $return;
	}

	public function get_professor_select(){
		$return = [];

		$query = $this->db
		->select(['p.ProfessorID', "CONCAT(p.FName, ' ', p.LName) AS Name"])
		->from('tblProfessors p')
		->get();

		foreach($query->result() as $row){
			$return[$row->ProfessorID] = ['val' => $row->ProfessorID, 'text' => $row->Name];
		}

		return $return;
	}

	public function get_building_select(){
		$return = [];

		$query = $this->db->get('tblBuildings');

		foreach($query->result() as $row){
			$return[$row->BuildingID] = [
				'val' => $row->BuildingID,
				'text' => $row->Building,
				'title' => $row->ShortName
			];
		}

		return $return;
	}

	public function get_room_select(){
		$return = [];

		$query = $this->db->get('tblRooms');
		foreach($query->result() as $row){
			$return[$row->BuildingID][$row->RoomID] = ['val' => $row->RoomID, 'text' => $row->RoomNum];
		}

		return $return;
	}

	public function get_calendar_data($data){
		$return = [
			'SemesterData' => [],
			'Courses' => [],
			'ProfessorNotes' => '',
			'Classes' => []
		];

		$semesterID = $data['semesterID'];
		$professorID = $data['professorID'];
		$buildingID = $data['buildingID'];
		$roomID = $data['roomID'];
		
		$query = $this->db
		->select(['s.*', 'tb.TimeBlockJSON'])
		->from('tblSemesters s')
		->join('tblTimeBlockSchedules tb', 'tb.TimeBlockScheduleID = s.TimeBlockScheduleID')
		->where('s.SemesterID', $semesterID)
		->get();

		foreach($query->result() as $row){
			$row->TimeBlockJSON = json_decode($row->TimeBlockJSON);
			$return['SemesterData'] = $row;
		}

		$query = $this->db
		->select(['c.*'])
		->from('tblCourses c')
		->where('c.Deleted', 0)
		->get();

		foreach($query->result() as $row){
			$row->CourseDisplayName = $row->CourseNum . ' ' . $row->Course;
			$return['Courses'][$row->CourseID] = $row;
		}

		if($professorID){
			$profNotes = '';
			$query = $this->db
			->select('p.Notes')
			->from('tblProfessors p')
			->where('p.ProfessorID', $professorID)
			->get();

			foreach($query->result() as $row){
				if($row->Notes){
					$profNotes = $row->Notes;
				}
			}

			$return['ProfessorNotes'] = $profNotes;
		}

		if($professorID || $buildingID || $roomID){

			$this->db
			->select(['c.*', 'cl.*','cs.*', 'r.*', 'b.*'])
			->from('tblCourses c')
			->join('tblClasses cl', 'cl.CourseID = c.CourseID')
			->join('tblClassSessions cs', 'cs.ClassID = cl.ClassID')
			->join('tblRooms r', 'r.RoomID = cl.RoomID')
			->join('tblBuildings b', 'b.BuildingID = r.BuildingID')
			->where('c.Deleted', 0);

			if($professorID > 0){
				$this->db->where('cl.ProfessorID', $professorID);
			}

			if($buildingID > 0){
				$this->db->where('b.BuildingID', $buildingID);
			}

			if($roomID > 0){
				$this->db->where('cl.RoomID', $roomID);
			}
			$query = $this->db->get();

			foreach($query->result() as $row){
				$row->WeekTimeBlockJSON = json_decode($row->WeekTimeBlockJSON);
				if(!array_key_exists($row->ClassID, $return['Classes'])){
					$return['Classes'][$row->ClassID] = ['ClassID' => $row->ClassID, 'CourseID' => $row->CourseID, 'ClassSessions' => []]
				}
				$return['Classes'][$row->ClassID]['ClassSessions'][$row->ClassSessionID] = ['STime' => $row->STime, 'ETime' => $row->ETime, 'MinLength' => $row->MinLength];
			}
		}

		return $return;
	}
}