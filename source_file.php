<?php


//####################################################################

function class_loader2($class){
	$base=strtolower($class);
	$base.='_class.php';
	$class='Examples/Demo_class/'.$base;
	if(file_exists($class)){		
		include_once $class;
	}	
}


function dnt(){
	return;
}

function gd($x){
	return $x;
}


function ckf($file){
	clearstatcache();
	$n=0;
	if(file_exists($file)){
		$n=filesize($file);
		unlink($file);
	}
	return $n;
}


?>