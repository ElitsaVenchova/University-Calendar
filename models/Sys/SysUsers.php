class SysUsers {
	private $username;
	private $password;
	private $firstName;
	private $surname;
	private $lastName;
	private $title;
	private $address;
	private $telefonNumber;
	private $email;
	private $visitingTime;
	private $cabinet;
	private $rownum;
	private $cathedralId;
	private $studyProgramId;
	private $admGroup;
	private $yearAtUniversity;
	private $isActive;
	private $notes;
	
	function __construct() {}
	
	function __construct($username, $password, $firstName, $surname, $lastName, $title, $address, $telefonNumber, $email, $visitingTime, $cabinet, $rownum, $cathedralId, $studyProgramId, $admGroup, $yearAtUniversity, $isActive, $notes) {
		$this->username = $username;
		$this->password = $password;
		$this->firstName = $firstName;
		$this->surname = $surname;
		$this->lastName = $lastName;
		$this->title = $title;
		$this->address = $address;
		$this->telefonNumber = $telefonNumber;
		$this->email = $email;
		$this->visitingTime = $visitingTime;
		$this->cabinet = $cabinet;
		$this->rownum = $rownum;
		$this->cathedralId = $cathedralId;
		$this->studyProgramId = $studyProgramId;
		$this->admGroup = $admGroup;
		$this->yearAtUniversity = $yearAtUniversity;
		$this->isActive = $isActive;
		$this->notes = $notes;
	}
	
		public function getUsername(){
		return $this->username;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function getFirstName(){
		return $this->firstName;
	}

	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}

	public function getSurname(){
		return $this->surname;
	}

	public function setSurname($surname){
		$this->surname = $surname;
	}

	public function getLastName(){
		return $this->lastName;
	}

	public function setLastName($lastName){
		$this->lastName = $lastName;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getAddress(){
		return $this->address;
	}

	public function setAddress($address){
		$this->address = $address;
	}

	public function getTelefonNumber(){
		return $this->telefonNumber;
	}

	public function setTelefonNumber($telefonNumber){
		$this->telefonNumber = $telefonNumber;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getVisitingTime(){
		return $this->visitingTime;
	}

	public function setVisitingTime($visitingTime){
		$this->visitingTime = $visitingTime;
	}

	public function getCabinet(){
		return $this->cabinet;
	}

	public function setCabinet($cabinet){
		$this->cabinet = $cabinet;
	}

	public function getRownum(){
		return $this->rownum;
	}

	public function setRownum($rownum){
		$this->rownum = $rownum;
	}

	public function getCathedralId(){
		return $this->cathedralId;
	}

	public function setCathedralId($cathedralId){
		$this->cathedralId = $cathedralId;
	}

	public function getStudyProgramId(){
		return $this->studyProgramId;
	}

	public function setStudyProgramId($studyProgramId){
		$this->studyProgramId = $studyProgramId;
	}

	public function getAdmGroup(){
		return $this->admGroup;
	}

	public function setAdmGroup($admGroup){
		$this->admGroup = $admGroup;
	}

	public function getYearAtUniversity(){
		return $this->yearAtUniversity;
	}

	public function setYearAtUniversity($yearAtUniversity){
		$this->yearAtUniversity = $yearAtUniversity;
	}

	public function getIsActive(){
		return $this->isActive;
	}

	public function setIsActive($isActive){
		$this->isActive = $isActive;
	}

	public function getNotes(){
		return $this->notes;
	}

	public function setNotes($notes){
		$this->notes = $notes;
	}
}