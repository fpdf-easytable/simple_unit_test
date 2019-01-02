<?php
namespace Abc\Def\Ghi;
class Number implements NumberInterface 
{
	private $x;
	public function __construct($x){
		$this->x=$this->is_number($x);
	}
	
	private function is_number($x){
		if(!is_int($x)){
			if(is_object($x) && get_class($x)==='Number'){
				return $x->toInt();
			}
			throw new \Exception("$x is not an integer");
			//return 34;
		}
		return $x;
	}
	
	public function add($y){
		return $this->x+=$this->is_number($y);
	}
	
	public function subtract($y){
		return $this->x-=$this->is_number($y);
	}

	public function multiply($y){
		return $this->x*=$this->is_number($y);
	}	

	public function divide($y){
		$z=$this->is_number($y);
		if($z==0){
			throw new Exception("Division by zero is not allowed");
		}
		return $this->x/=$z;
	}

	public function toInt(){
		return $this->x;
	}

}