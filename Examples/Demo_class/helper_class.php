<?php

class Helper{
	public $sleeping;
	function __construct($sleep){
		$this->sleeping=$sleep;
	}
	function do_something(){
		sleep($this->sleeping);
	}
}




?>