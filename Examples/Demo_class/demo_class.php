<?php

class Demo {
	
   private $name, 
      $last_name, 
            $age, 
            $data;

	public function __construct(){
		$this->name='Elephant';
		$this->size='Very big';
		$this->weight='Very heavy';
		$this->age=0;
		$this->data=new Helper(5);
	}
	
	public function get_data($str){
		$this->data->do_something();
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
	}

	public function print_to_file($str){
		$output='/tmp/zzzz_demo';
		$h=fopen($output, 'a');
		fwrite($h, $str);
		fclose($h);
	}
}



?>