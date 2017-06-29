<?php
class NomSemesterTypes {
	private $id;
	private $shortName;
	private $name;
	private $description;
	private $isActive;
	
	function __construct() {}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
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
	
	public function getIsActiveTxt(){
		return $this->isActive != null && strcmp ( $this->isActive , "Y" ) == 0 ? "Да" : "Не";
	}
}
?>