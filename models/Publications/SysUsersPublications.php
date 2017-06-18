class SysUsersPublications {
	private $id;
	private $author;
	private $publucationId;
	
	function __construct() {}
	
	function __construct($id, $author, $publucationId) {
		$this->id = $id;
		$this->author = $author;
		$this->publucationId = $publucationId;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getPublucationId(){
		return $this->publucationId;
	}

	public function setPublucationId($publucationId){
		$this->publucationId = $publucationId;
	}
}