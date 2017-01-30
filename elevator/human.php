<?
namespace lift;

interface HumanInterface {
	public function call($callTime, $startFloor);
	public function setIndex($i);
	public function getIndex();	
	public function name();
	public function waitingTime();
	public function callTime();
	public function startFloor();
}

abstract class Human implements HumanInterface {
	protected   $name,
	            $waitingTime = 0,
				$callTime,
				$startFloor,
			    $i;

	function call($callTime, $startFloor) {
		$this->startFloor = (int) $startFloor;
		$this->callTime = $callTime;
	}	
	
	function setIndex($i) {
		$this->i = $i;
	}
	function getIndex() {
		return $this->i;
	}	
	function name() {
		return $this->name;
	}		
	function waitingTime() {
		return $this->waitingTime;
	}	
	function callTime() {
		return $this->callTime;
	}	
	function startFloor() {
		return $this->startFloor;
	}	
		
}



?>


