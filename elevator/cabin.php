<?
namespace lift;
use lift;

class Cabin extends Records {
	/**
	 * @param Elevator $elevator
	 */
	public function serveCall(Elevator $elevator) {
		lift\Logger::info('cabin', $this->arr);
		for($i = 0; $i<count($this->arr); $i++){
			$p = $this->arr[$i];			
			$moveTime = $elevator->moveTime($elevator->currentFloor, $p->endFloor());
			lift\Logger::passenger('endFloor', $p);
			$elevator->currentTime = lift\Helper::addSeconds($moveTime, $elevator->currentTime);
			lift\Logger::elevator('moveTime', $moveTime);
			$elevator->currentFloor = $p->endFloor();
			// passenger is getting out of the cabin
			$p->setIndex($i);
			$this->remove($p);	
			$elevator->removeFromCabin($p);
			// check if there is someone who wants get in
			$elevator->checkSimilarFloor();					
		}
		$elevator->move();		
	}
}
