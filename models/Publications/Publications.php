class Publications {
	private $id;
	private $title;
	private $year;
	private $publucation;
	
	function __construct() {}
	
	function __construct($id, $title, $year, $publucation) {
		$this->id = $id;
		$this->title = $title;
		$this->year = $year;
		$this->publucation = $publucation;
	}
	
		public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getYear(){
		return $this->year;
	}

	public function setYear($year){
		$this->year = $year;
	}

	public function getPublucation(){
		return $this->publucation;
	}

	public function setPublucation($publucation){
		$this->publucation = $publucation;
	}
}