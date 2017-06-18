class SysUserRoles {
	private $id;
	private $username;
	private $role;
	
	function __construct() {}
	
	function __construct($id, $username, $role) {
		$this->id = $id;
		$this->username = $username;
		$this->role = $role;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getUsername(){
		return $this->username;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function getRole(){
		return $this->role;
	}

	public function setRole($role){
		$this->role = $role;
	}
}