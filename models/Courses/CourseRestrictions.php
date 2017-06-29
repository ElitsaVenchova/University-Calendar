<?php 
class CourseRestrictions {
	private $id;
	private $studyProgramId;
	private $courseId;
	private $yearAtUniversity;
	
	function __construct() {}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getStudyProgramId(){
		return $this->studyProgramId;
	}

	public function setStudyProgramId($studyProgramId){
		$this->studyProgramId = $studyProgramId;
	}

	public function getCourseId(){
		return $this->courseId;
	}

	public function setCourseId($courseId){
		$this->courseId = $courseId;
	}

	public function getYearAtUniversity(){
		return $this->yearAtUniversity;
	}

	public function setYearAtUniversity($yearAtUniversity){
		$this->yearAtUniversity = $yearAtUniversity;
	}
}
?>