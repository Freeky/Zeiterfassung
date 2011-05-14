<?php
class OverviewFilter 
{
	private $from;
	private $to;
	private $client = "";
	private $planned = true;
	private $inprogress = true;
	private $done = true;
	private $canceled = true;
	
	function __construct() {
		$this->from = new DateTime();
		$this->to = new DateTime();
		$this->from->modify("-1 week");
	}
	
	/*----SETTER----*/
	public function setFrom($date) {
		$parsedDate = date_parse($date);
		if($parsedDate)
			$this->from->setDate($parsedDate['year'],
								 $parsedDate['month'],
								 $parsedDate['day']);
	}
	
	public function setTo($date) {
		$parsedDate = date_parse($date);
		if($parsedDate)
			$this->to->setDate($parsedDate['year'],
							   $parsedDate['month'],
							   $parsedDate['day']);
	}
	
	public function setClient($str) {
		$this->client = $str;
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
	public function getFrom(){
		return $this->from->format("d.m.Y");
	}
	
	public function getTo() {
		return $this->to->format("d.m.Y");
	}
	
	public function getClient() {
		return $this->client;
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