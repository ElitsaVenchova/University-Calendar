class CoursesStudents {
	private $id;
	private $student;
	private $courseId;
	private $year;
	private $semesterTypeId;
	private $status;
	private $requestTime;
	
	function __construct() {}
	
	function __construct($id, $student, $courseId, $year, $semesterTypeId, $status, $requestTime) {
		$this->id = $id;
		$this->student = $student;
		$this->courseId = $courseId;
		$this->year = $year;
		$this->semesterTypeId = $semesterTypeId;
		$this->status = $status;
		$this->requestTime = $requestTime;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getStudent(){
		return $this->student;
	}

	public function setStudent($student){
		$this->student = $student;
	}

	public function getCourseId(){
		return $this->courseId;
	}

	public function setCourseId($courseId){
		$this->courseId = $courseId;
	}

	public function getYear(){
		return $this->year;
	}

	public function setYear($year){
		$this->year = $year;
	}

	public function getSemesterTypeId(){
		return $this->semesterTypeId;
	}

	public function setSemesterTypeId($semesterTypeId){
		$this->semesterTypeId = $semesterTypeId;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getRequestTime(){
		return $this->requestTime;
	}

	public function setRequestTime($requestTime){
		$this->requestTime = $requestTime;
	}
}