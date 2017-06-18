class News {
	private $id;
	private $publisher;
	private $publishDate;
	private $title;
	private $content;
	
	function __construct() {}
	
	function __construct($id, $publisher, $publishDate, $title, $content) {
		$this->id = $id;
		$this->publisher = $publisher;
		$this->publishDate = $publishDate;
		$this->title = $title;
		$this->content = $content;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getPublisher(){
		return $this->publisher;
	}

	public function setPublisher($publisher){
		$this->publisher = $publisher;
	}

	public function getPublishDate(){
		return $this->publishDate;
	}

	public function setPublishDate($publishDate){
		$this->publishDate = $publishDate;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getContent(){
		return $this->content;
	}

	public function setContent($content){
		$this->content = $content;
	}
}