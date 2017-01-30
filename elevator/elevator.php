<?
namespace lift;

require_once('logger.php');
require_once('helper.php');
require_once('speed.php');
require_once('human.php');
require_once('passenger.php');
require_once('prankster.php');
require_once('records.php');
require_once('cabin.php');
require_once('queue.php');



use lift;




interface ElevatorInterface {
	public function setDefaultTime($value);
	public function setDefaultFloor($value);
}
interface MoveElevatorInterface {
	public function removeFromCabin($p);
	public function setPassenger($p);
	public function checkSimilarFloor();
	public function move();	
	public function add($p);	
}


class Elevator extends Speed implements ElevatorInterface, MoveElevatorInterface {
			
	protected 	$speedUp,         	// speed when going up (m/sec)
				$speedDown,     	// speed when going down (m/sec)	
				$acceleration,  	// m/sec2
				$deceleration,  	// m/sec2
				$floorHeight;     	// m				
				
	private 	$queue,
				$cabin,
				$maxPassengersWeight;
				
	public 		$currentFloor = 1,
				$currentTime;	
			
	function __construct($settings) {

		foreach ($settings as $key => $value) {
			$this->$key = lift\Helper::defaultValue($value);			
		}
		$this->currentTime = date('00:00:00');
		$this->queue = new Queue();
		$this->cabin = new Cabin();
	}
		
	public function setDefaultTime($value) {
		$this->currentTime = $value;
	}
	public function setDefaultFloor($value) {
		$this->currentFloor = round($value);
		lift\Logger::elevator('floor', $this->currentFloor);
	}
	
	private function changeCurrentTime($sec){
		$this->currentTime = lift\Helper::addSeconds($sec, $this->currentTime);
		lift\Logger::elevator('time', $this->currentTime);
	}
	
	public function removeFromCabin($p){
		$this->changeCurrentTime($p->movingTime());
		lift\Logger::passenger('removePassenger', $p);
		$this->maxPassengersWeight += $p->weight();		
	}	

	public function setPassenger($p){
		if (method_exists($p, 'endFloor')){
			// check his weight
			if($this->maxPassengersWeight >  $p->weight()) {
				lift\Logger::elevator('limit', $this->maxPassengersWeight);
				lift\Logger::passenger('AddCabin', $p);
				// add to cabin if this passenger goes anywhere
				$this->cabin->add($p);
				$this->maxPassengersWeight -= $p->weight();
				$this->changeCurrentTime($p->movingTime());
				lift\Logger::passenger('getInTime', $p);				
			} else {
				lift\Logger::passenger('toFat', $p);
			}
		} else {
			lift\Logger::passenger('doesntGo', $p);
		}			
	}
	
	public function checkSimilarFloor(){
		$this->queue->similarFloor($this);
	}
	
	public function add($p) {
		if($p->callTime() >= $this->currentTime ) $this->queue->add($p);
	}
	public function move() {
		
		if($this->cabin->checkArr()) {
			// serve calls from the cabin
			$record = 'cabin';				
		} else {
			// serve calls outside the cabin
			$record = 'queue';
		}
		$this->$record->serveCall($this);
	}

}

?>


