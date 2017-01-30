<?
namespace lift;

class Passenger extends Human  {
	private $weight,
			$movingTime,
			$endFloor;
				
	function __construct($name, $waitingTime, $weight, $movingTime){
		$this->name = $name;
		$this->waitingTime = $waitingTime;		
		$this->weight = $weight;
		$this->movingTime = $movingTime;
	}
	function goesTo($endFloor) {
		$this->endFloor = (int) $endFloor;
	}	
	function endFloor() {
		return $this->endFloor;
	}	
	function movingTime() {
		return $this->movingTime;
	}		
	function weight() {
		return $this->weight;
	}	
}