<?php
namespace SimpleUnitTest;

class Test extends Unit_Test
{
	/*
	If you need to add a curl option do it here.
	
	Note: This method is an abstract method from the parent class
			so it needs to be implemented at least trivially
	
	*/
	protected function __init(){
		//self::$CURL_OPTIONS[CURLOPT_TIMEOUT]=30;
	}

	
	public function print_results(){
		$html='<table class="simple_test_result" >
			<tr style="height:4em;"><td colspan="8"><b>Class: </b>'. $this->meta['Class'] . '
			<br/>Parameters: ' . $this->meta['Parameters'] . '<br/>';
		
		foreach($this->result as $result){
			if(count($result['Errors'])){
				$html.='<tr><td colspan="8"><b>Error</b></td></tr>';
				foreach($result['Errors'] as $error){
					$html.='<tr><td colspan="8">';
					foreach($error as $k=>$v){
						$html.=$k . ': '. $v . '<br/>'; 
					}
					$html.='</td></tr>';
				}
			}
		
			if(isset($result['Method']) && isset($result['Tests'])){
				
				$html.='<tr style="height:3em;"><td colspan="8"><b>Method: </b>' .$result['Method'] . '
					<b>Number of tests: </b>'. count($result['Tests']) . '</td></tr>';

				if(isset($result['Tests']) && count($result['Tests'])){
					$html.='<tr><th>Test</th><th>Status</th><th>Result</th><th>Expected Value</th><th>Parameters</th><th>Elapsed time</th><th>MB</th><th style="width:30%;">Exceptions/Warnings</th></tr>';
					foreach($result['Tests'] as $tn=>$data){
						$class='class="warning"';
						if($data['Status']=='Passed'){
							$class='class="passed"';
						}
						elseif($data['Status']=='Failed'){
							$class='class="fail"';
						}
			
						if(is_array($data['Expected Value'])|| is_object($data['Expected Value'])){
							$data['Expected Value']=var_export($data['Expected Value'],true);
						}
						if(is_array($data['Result'])|| is_object($data['Result'])){
							$data['Result']=var_export($data['Result'], true);
						}
						$html.='<tr '. $class . '>
							<td>'. $tn .'</td>
							<td>' . $data['Status'] .' </td>
							<td>' . $data['Result'] . '</td>
							<td>' . $data['Expected Value'] . '</td>
							<td>' . implode('<br/>', $data['Parameters']) . '</td>
							<td>' . $data['Elapsed Time'] . '</td>
							<td>' . $data['Memory Usage'] . '</td>
							<td>' . $data['Exception'] . ' ' . $data['Warnings'] . '</td>
							</tr>';
					}
				}
				if(isset($result['SpyLog'])){
					$html.='<tr style="height:2.5em;"><td colspan="8"><b>Spies</b></td></tr>';
					foreach($result['SpyLog'] as $class=>$dataset){
						foreach($dataset as $spy=>$data){						
							$html.="<tr><td><b>[{$class}] {$spy}</b></td><td colspan=\"7\">". implode('<br/>', $data) ."</td></tr>";
						}
					}
				}	

			}
		}
		$html.='</table>';
		return $html;
	}

}


?>