<?
namespace lift;

interface RecordsInterface {
	public function add($item);
	public function remove($p);
	public function checkArr();
}

abstract class Records implements RecordsInterface {
	
	protected $arr = array();
	
	abstract function serveCall(Elevator $elevator);
	
	public function add($item){
		$this->arr[] = $item;
	}
	public function remove($p){
		array_splice($this->arr, $p->getIndex(), 1);	
	}		
	public function checkArr(){
		return (count($this->arr) > 0);

	}
}
