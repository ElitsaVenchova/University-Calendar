<?php
class Rooms {
	private $id;
	private $num;
	private $place;
	private $typeId;
	private $workStations;
	private $description;
	private $isActive;
	
	function __construct() {}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getNum(){
		return $this->num;
	}

	public function setNum($num){
		$this->num = $num;
	}

	public function getPlace(){
		return $this->place;
	}

	public function setPlace($place){
		$this->place = $place;
	}

	public function getTypeId(){
		return $this->typeId;
	}

	public function setTypeId($typeId){
		$this->typeId = $typeId;
	}

	public function getWorkStations(){
		return $this->workStations;
	}

	public function setWorkStations($workStations){
		$this->workStations = $workStations;
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