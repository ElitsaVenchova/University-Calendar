class MasterEvents {
	private $id;
	private $creater;
	private $eventType;
	private $isActive;
	private $courseId;
	
	function __construct() {}
	
	function __construct($id, $creater, $eventType, $isActive, $courseId) {
		$this->id = $id;
		$this->creater = $creater;
		$this->eventType = $eventType;
		$this->isActive = $isActive;
		$this->courseId = $courseId;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getCreater(){
		return $this->creater;
	}

	public function setCreater($creater){
		$this->creater = $creater;
	}

	public function getEventType(){
		return $this->eventType;
	}

	public function setEventType($eventType){
		$this->eventType = $eventType;
	}

	public function getIsActive(){
		return $this->isActive;
	}

	public function setIsActive($isActive){
		$this->isActive = $isActive;
	}

	public function getCourseId(){
		return $this->courseId;
	}

	public function setCourseId($courseId){
		$this->courseId = $courseId;
	}
}