<?php
class CoursesTeachers {
	private $id;
	private $teacher;
	private $courseId;
	private $year;
	private $isActive;
	
	function __construct() {}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getTeacher(){
		return $this->teacher;
	}

	public function setTeacher($teacher){
		$this->teacher = $teacher;
	}

	public function getCourseId(){
		return $this->courseId;
	}

	public function setCourseId($courseId){
		$this->courseId = $courseId;
	}

	public function getYear(){
		return $this->year;
	}

	public function setYear($year){
		$this->year = $year;
	}

	public function getIsActive(){
		return $this->isActive;
	}

	public function setIsActive($isActive){
		$this->isActive = $isActive;
	}
}
?>