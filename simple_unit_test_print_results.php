<?php
/*
This file is use to implement the print_result method of the Test class.
Here you define you own function to print the result of the tests

*/

function print_results(&$results, $meta){
	//var_dump($results);
	$result=&$results[0];
	//var_dump($result);
	if(isset($result['Method']) && isset($result['Tests'])){
		$html='<table class="simple_test_result" >
		<tr style="height:4em;"><td colspan="8"><b>Class: </b>'. $meta['Class'] . '
		<br/>Parameters: ' . $meta['Parameters'] . '<br/>';
		foreach($results as $result){
			$html.='<tr style="height:3em;"><td colspan="8"><b>Method: </b>' .$result['Method'] . '
			<b>Number of tests: </b>'. count($result['Tests']) . '</td></tr>';
			if(isset($result['Errors']) && count($result['Errors'])){
				$html.='<tr><td colspan="8"><b>Error</b></td></tr>';
				foreach($result['Errors'] as $error){
					$html.='<tr><td colspan="8">';
					foreach($error as $k=>$v){
						$html.=$k . ': '. $v . '<br/>'; 
					}
					$html.='</td></tr>';
				}
			}

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
					<td>' . $data['Parameters'] . '</td>
					<td>' . $data['Elapsed Time'] . '</td>
					<td>' . $data['Memory Usage'] . '</td>
					<td>' . $data['Exception'] . ' ' . $data['Warnings'] . '</td>
				</tr>';
			}
		}
	}
	$html.='</table>';
	return $html;
}
		}
	


?>