<?php
class OverviewFilter 
{
	private $name = "";
	private $employer = "";
	private $description = "";
	private $createFrom;
	private $createTo;
	private $deadlineFrom;
	private $deadlineTo;
	private $planned = true;
	private $inprogress = true;
	private $done = true;
	private $canceled = true;
	
	function __construct() {
		$this->createFrom = new DateTime();
		$this->createTo = new DateTime();
		$this->deadlineFrom = new DateTime();
		$this->deadlineTo = new DateTime();
		$this->createFrom->modify("-1 week");
		$this->deadlineFrom->modify("-1 week");
		$this->deadlineTo->modify("+1 week");
	}
	
	/*----SETTER----*/

	public function setName($str) {
		$this->name = $str;
	}
	
	public function setEmployer($str) {
		$this->employer = $str;
	}
	
	public function setDescription($str) {
		$this->description = $str;
	}
	
	public function setCreatedateFrom($date) {
		$parsedDate = date_parse($date);
		if($parsedDate)
			$this->createFrom->setDate($parsedDate['year'],
								 $parsedDate['month'],
								 $parsedDate['day']);
	}
	
	public function setCreatedateTo($date) {
		$parsedDate = date_parse($date);
		if($parsedDate)
			$this->createTo->setDate($parsedDate['year'],
							   $parsedDate['month'],
							   $parsedDate['day']);
	}
	
	public function setDeadlineFrom($date) {
		$parsedDate = date_parse($date);
		if($parsedDate)
			$this->deadlineFrom->setDate($parsedDate['year'],
								 $parsedDate['month'],
								 $parsedDate['day']);
	}
	
	public function setDeadlineTo($date) {
		$parsedDate = date_parse($date);
		if($parsedDate)
			$this->deadlineTo->setDate($parsedDate['year'],
							   $parsedDate['month'],
							   $parsedDate['day']);
	}
	
	public function setPlanned($bool) {
		$this->planned = $bool;
	}
	
	public function setInprogress($bool) {
		$this->inprogress = $bool;
	}
	
	public function setDone($bool) {
		$this->done = $bool;
	}
	
	public function setCanceled($bool) {
		$this->canceled = $bool;
	}
	
	/*----GETTER----*/

	public function getName() {
		return $this->name;
	}
	
	public function getEmployer() {
		return $this->employer;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getCreatedateFrom(){
		return $this->createFrom;
	}
	
	public function getCreatedateTo() {
		return $this->createTo;
	}
	
	public function getDeadlineFrom(){
		return $this->deadlineFrom;
	}
	
	public function getDeadlineTo() {
		return $this->deadlineTo;
	}
	
	public function getPlanned() {
		return $this->planned;
	}
	
	public function getInprogress() {
		return $this->inprogress;
	}
	
	public function getDone() {
		return $this->done;
	}
	
	public function getCanceled() {
		return $this->canceled;
	}
}
?>