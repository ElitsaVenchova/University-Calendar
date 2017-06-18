class Rooms {
	private $id;
	private $num;
	private $palce;
	private $typeId;
	private $workStations;
	private $description;
	private $isActive;
	
	function __construct() {}
	
	function __construct($id, $num, $palce, $typeId, $workStations, $description, $isActive) {
		$this->id = $id;
		$this->num = $num;
		$this->palce = $palce;
		$this->typeId = $typeId;
		$this->workStations = $workStations;
		$this->description = $description;
		$this->isActive = $isActive;
	}
	
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

	public function getPalce(){
		return $this->palce;
	}

	public function setPalce($palce){
		$this->palce = $palce;
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
}