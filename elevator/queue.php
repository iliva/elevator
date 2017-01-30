<?
namespace lift;
use lift;

class Queue extends Records {
	
	private function checkPassenger($p, $currentTime){
		$waitingTime = lift\Helper::addSeconds($p->waitingTime(), $p->callTime());
		if($waitingTime < $currentTime) {
			lift\Logger::passenger('notWaiting', $p, $waitingTime);
			// remove from elevator queue
			$this->remove($p);				
			return false;
		} else {
			return true;
		}
			
	}

	/**
	 * @param Elevator $elevator
	 */
	public function similarFloor(Elevator $elevator){
		foreach ($this->arr as $key => $p) {
			if($p->startFloor() == $elevator->currentFloor) {
				lift\Logger::passenger('similarFloor', $p);
				$p->setIndex($key);
				$elevator->setPassenger($p);
				// remove from elevator queue
				$this->remove($p);				
			}					
		}		
	}

	/**
	 * @param Elevator $elevator
	 */	
	public function serveCall(Elevator $elevator) {
		lift\Logger::info('queue', $this->arr);
		if(empty($this->arr)) {
			lift\Logger::info('queueEmpty');
			return false;
		}
		for($i = 0; $i<count($this->arr); $i++){
			$p = $this->arr[$i];		
			$p->setIndex($i);
			// check if passenger is here
			if($this->checkPassenger($p, $elevator->currentTime)) {
				if($p->callTime() > $elevator->currentTime) $elevator->currentTime = $p->callTime();
				lift\Logger::elevator('time', $elevator->currentTime);
				lift\Logger::passenger('calls', $p);
				// move time
				$moveTime = $elevator->moveTime($elevator->currentFloor, $p->startFloor());
				$elevator->currentTime = lift\Helper::addSeconds($moveTime, $elevator->currentTime);
				lift\Logger::elevator('time', $elevator->currentTime);
				lift\Logger::elevator('moveTime', $moveTime);
				$elevator->currentFloor = $p->startFloor();
				// passenger is getting in
				if($this->checkPassenger($p, $elevator->currentTime)) {
					$elevator->setPassenger($p);
					// remove from elevator queue
					$this->remove($p);
					// check if anybody else is ready to get in from this floor
					$this->similarFloor($elevator);					
				}

							
			}
			$elevator->move();	
		}		
	}	
}
