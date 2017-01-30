<?
namespace lift;

interface SpeedInterface {
	public function moveTime($startFloor, $endFloor);
}
abstract class Speed implements SpeedInterface {
	

	// time for elevator's acceleration/deceleration		
	private function timeChangeSpeed($speed, $changeSpeed){  
		if($changeSpeed <=0)  return 0;
		return $speed / $changeSpeed;
	} 
	
	// passed way for the acceleration/deceleration time
	private function pathChangeSpeed($speed, $changeSpeed){  
		if($changeSpeed <=0)  return 0;
		$timeChangeSpeed = $this->timeChangeSpeed($speed, $changeSpeed);
		return  $changeSpeed * pow($timeChangeSpeed, 2) / 2;
	}	
	
	// time spend for one floor without start/stop
	private function timeOneFloor($height, $speed){  
		return $height/$speed;
	}	
	
	// time spend for one floor with start and stop
	private function timeStartStopSpeed($height, $speed){  
		
		$pathAcceleration = $this->pathChangeSpeed($speed, $this->acceleration);
		$timeAcceleration = $this->timeChangeSpeed($speed, $this->acceleration);
		$pathDeceleration = $this->pathChangeSpeed($speed, $this->deceleration);
		$timeDeceleration = $this->timeChangeSpeed($speed, $this->deceleration);	

		$timeWithoutAcceleration = ($height - $pathAcceleration - $pathDeceleration )/$speed; 
		$totalTime = $timeWithoutAcceleration + $timeDeceleration + $timeAcceleration;
	
		return $totalTime;
	}	
	
	// time for passing floors 
	private function wayTime($floors, $direction){
		
		switch($direction){
			case 'up':
				$speed = $this->speedUp;
				break;
			case 'down':
				$speed = $this->speedDown;
				break;		
			default:
				$speed = $this->speedUp;
		}
		
		if($speed <= 0)  throw new Exception ("Infinite time");
		
		$timeStartStopSpeed = $this->timeStartStopSpeed($this->floorHeight, $speed);
		$timeOneFloor = $this->timeOneFloor($this->floorHeight, $speed);
		return ($floors-1) * $timeOneFloor + $timeStartStopSpeed;		
	}

	public function moveTime($startFloor, $endFloor){
		
		$way = $endFloor - $startFloor;
		if($way == 0) return 0;
		
		$direction = ($way < 0) ? 'down' : 'up'; 
		
		try {
			return $this->wayTime(abs($way), $direction);
		} catch (Exception $e) {
			echo $e->getMessage();	
		}
	}	
}