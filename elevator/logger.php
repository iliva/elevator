<?
namespace lift;

class Logger{
	
	private function __construct() {}
	
	private function listView($p){
		return '&nbsp;&nbsp;-&nbsp;&nbsp;'.$p->name().', 
			callTime: '.$p->callTime().', 
			calls from '.$p->startFloor().' floor<br />';
	}
	static function info($text, $array = false) {
		switch($text){
			case 'queue':
				echo '<br />Cabine is empty, let\'s check passengers queue<br />';
				foreach($array as $item) {
					echo self::listView($item);
				}
				echo '<br />';
				break;
			case 'cabin':
				echo '<br />Cabin is not empty, let\'s check cabin calls<br />';
				foreach($array as $item) {
					echo self::listView($item);
				}
				echo '<br />';
				break;		
			case 'queueEmpty':
				echo 'There are no passengers waiting for the elevator<br />';
				break;	
		}			
	
	}
	
	static function elevator($text, $value = false) {
		switch($text){
			case 'limit':
				echo 'Elevator can accommodate '.$value.' more kilo. ';
				break;	
			case 'floor':
				echo 'Elevator is on the '.$value.' floor<br />';
				break;	
			case 'time':
				echo $value.': ';
				break;	
			case 'moveTime':
				echo 'Elevator\'s travel time: '.$value.' seconds<br />';
				break;				
		}
	}
	public static function passenger($text, $p, $t = false) {
		switch($text){
			case 'calls':
				echo $p->name().' calls elevator to the '.$p->startFloor().' floor<br />';
				break;					
			case 'notWaiting':
				echo $p->name().' is tired of waiting for the elevator and went by feet. He/She was waiting till '.$t.'.<br />';
				break;
			case 'toFat':
				echo $p->name().'\'s weight: '.$p->weight().'kg and there is not enough space for him<br />';
				break;				
			case 'AddCabin':
				echo $p->name().'\'s weight: '.$p->weight().'kg. '.$p->name().' is getting in.<br />';
				break;	
			case 'getInTime':
				echo 'It took '.$p->name().' '.$p->movingTime().' sec to get in<br />';
				break;								
			case 'similarFloor':
				echo '<br />There is '.$p->name().' on the current('.$p->startFloor().') floor! Would you get in?<br />';
				break;	
			case 'endFloor':
				echo '<br />'.$p->name().' is in the elevator\'s cabin, he/she wants to go to the '.$p->endFloor().' floor<br />';
				break;					
			case 'removePassenger':
				echo $p->name().' is getting out of the cabin for '.$p->movingTime().' sec<br />';
				break;
			case 'doesntGo':
				echo $p->name().' doesn\'t want to set into the cabine. He is a naughty prankster and just run away<br />';
				break;
				
		}		
	}
	
}

?>


