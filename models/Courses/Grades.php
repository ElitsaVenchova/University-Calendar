<?php
class Grades {
	private $id;
	private $year;
	private $courseId;
	private $sessionTypeId;
	private $grade;
	private $credits;
	private $student;
	
	function __construct() {}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getYear(){
		return $this->year;
	}

	public function setYear($year){
		$this->year = $year;
	}

	public function getCourseId(){
		return $this->courseId;
	}

	public function setCourseId($courseId){
		$this->courseId = $courseId;
	}

	public function getSessionTypeId(){
		return $this->sessionTypeId;
	}

	public function setSessionTypeId($sessionTypeId){
		$this->sessionTypeId = $sessionTypeId;
	}

	public function getGrade(){
		return $this->grade;
	}

	public function setGrade($grade){
		$this->grade = $grade;
	}

	public function getCredits(){
		return $this->credits;
	}

	public function setCredits($credits){
		$this->credits = $credits;
	}

	public function getStudent(){
		return $this->student;
	}

	public function setStudent($student){
		$this->student = $student;
	}
}
?>