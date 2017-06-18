class EventViewGroups {
	private $id;
	private $masterEventId;
	private $type;
	private $courseId;
	private $yearAtUniversity;
	private $degreeId;
	private $cathedralId;
	private $studyProgramId;
	
	function __construct() {}
	
	function __construct($id, $masterEventId, $type, $courseId, $yearAtUniversity, $degreeId, $cathedralId, $studyProgramId) {
		$this->id = $id;
		$this->masterEventId = $masterEventId;
		$this->type = $type;
		$this->courseId = $courseId;
		$this->yearAtUniversity = $yearAtUniversity;
		$this->degreeId = $degreeId;
		$this->cathedralId = $cathedralId;
		$this->studyProgramId = $studyProgramId;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getMasterEventId(){
		return $this->masterEventId;
	}

	public function setMasterEventId($masterEventId){
		$this->masterEventId = $masterEventId;
	}

	public function getType(){
		return $this->type;
	}

	public function setType($type){
		$this->type = $type;
	}

	public function getCourseId(){
		return $this->courseId;
	}

	public function setCourseId($courseId){
		$this->courseId = $courseId;
	}

	public function getYearAtUniversity(){
		return $this->yearAtUniversity;
	}

	public function setYearAtUniversity($yearAtUniversity){
		$this->yearAtUniversity = $yearAtUniversity;
	}

	public function getDegreeId(){
		return $this->degreeId;
	}

	public function setDegreeId($degreeId){
		$this->degreeId = $degreeId;
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
}