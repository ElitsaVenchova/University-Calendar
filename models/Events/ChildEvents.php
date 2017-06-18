class ChildEvents {
	private $id;
	private $masterId;
	private $roomId;
	private $classDate;
	private $fromHour;
	private $toHour;
	private $title;
	private $description;
	
	function __construct() {}
	
	function __construct($id, $masterId, $roomId, $classDate, $fromHour, $toHour, $title, $description) {
		$this->id = $id;
		$this->masterId = $masterId;
		$this->roomId = $roomId;
		$this->classDate = $classDate;
		$this->fromHour = $fromHour;
		$this->toHour = $toHour;
		$this->title = $title;
		$this->description = $description;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getMasterId(){
		return $this->masterId;
	}

	public function setMasterId($masterId){
		$this->masterId = $masterId;
	}

	public function getRoomId(){
		return $this->roomId;
	}

	public function setRoomId($roomId){
		$this->roomId = $roomId;
	}

	public function getClassDate(){
		return $this->classDate;
	}

	public function setClassDate($classDate){
		$this->classDate = $classDate;
	}

	public function getFromHour(){
		return $this->fromHour;
	}

	public function setFromHour($fromHour){
		$this->fromHour = $fromHour;
	}

	public function getToHour(){
		return $this->toHour;
	}

	public function setToHour($toHour){
		$this->toHour = $toHour;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}
}