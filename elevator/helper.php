<?
namespace lift;

class Helper {

	private function __construct() {}
	
	public static function defaultValue($value){
		return ($value > 0) ? $value : 0;
	}	
	public static function addSeconds($sec, $d) {
		return date("H:i:s", strtotime($d)+$sec);
	}		

}

?>


