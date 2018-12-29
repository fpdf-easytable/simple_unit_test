<?php

class Demo {
	
   private $name, $last_name, $age, $data;
	public function __construct(){
		$this->name='Elephant';
		$this->size='Very big';
		$this->weight='Very heavy';
		$this->age=0;
		$this->data=new Helper('Hola');
	}
	
	public function get_data($str){
		$this->get_old();
		if(isset($this->$str)){
			return $this->$str;
		}
		else{
			return false;
		}
	}
	
	public function get_old(){
		$this->age++;
		return $this->age;
	}
	
	

	public function print_to_file(){
		$h=fopen('/tmp/zzzz_demo', 'w');
		fwrite($h, var_export($this, true));
		fclose($h);
	}
}



?>