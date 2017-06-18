class EventViewUsers {
	private $id;
	private $type;
	private $masterEventId;
	private $username;
	private $direction;
	
	function __construct() {}
	
	function __construct($id, $type, $masterEventId, $username, $direction) {
		$this->id = $id;
		$this->type = $type;
		$this->masterEventId = $masterEventId;
		$this->username = $username;
		$this->direction = $direction;
	}
	
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

	public function getMasterEventId(){
		return $this->masterEventId;
	}

	public function setMasterEventId($masterEventId){
		$this->masterEventId = $masterEventId;
	}

	public function getUsername(){
		return $this->username;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function getDirection(){
		return $this->direction;
	}

	public function setDirection($direction){
		$this->direction = $direction;
	}
}