<?php
class Courses {
	private $id;
	private $type;
	private $categoryId;
	private $shortName;
	private $name;
	private $credits;
	private $signKey;
	private $semesterStudents;
	private $description;
	private $isActive;
	
	function __construct() {}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getType(){
		return $this->type;
	}

	public function setType($type){
		$this->type = $type;
	}

	public function getCategoryId(){
		return $this->categoryId;
	}

	public function setCategoryId($categoryId){
		$this->categoryId = $categoryId;
	}

	public function getShortName(){
		return $this->shortName;
	}

	public function setShortName($shortName){
		$this->shortName = $shortName;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getCredits(){
		return $this->credits;
	}

	public function setCredits($credits){
		$this->credits = $credits;
	}

	public function getSignKey(){
		return $this->signKey;
	}

	public function setSignKey($signKey){
		$this->signKey = $signKey;
	}

	public function getSemesterStudents(){
		return $this->semesterStudents;
	}

	public function setSemesterStudents($semesterStudents){
		$this->semesterStudents = $semesterStudents;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}

	public function getIsActive(){
		return $this->isActive;
	}

	public function setIsActive($isActive){
		$this->isActive = $isActive;
	}
}
?>