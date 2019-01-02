<?php

namespace Math;

//use WebService\WebRegister;
use WebService;

class Calculator_wrapper extends Calculator2{

	function __construct(){
		//$rgtr=new WebRegister();
		$rgtr=new WebService\WebRegister();
		parent::__construct($rgtr);
	}

}




?>