class SysRoles {
	private $id;
	private $code;
	private $name;
	private $description;
	
	function __construct() {}
	
	function __construct($id, $code, $name, $description) {
		$this->id = $id;
		$this->code = $code;
		$this->name = $name;
		$this->description = $description;
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getCode(){
		return $this->code;
	}

	public function setCode($code){
		$this->code = $code;
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
}