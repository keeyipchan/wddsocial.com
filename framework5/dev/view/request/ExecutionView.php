<?php

namespace Framework5\Dev;

/**
* 
* 
*/

class ExecutionView implements \Framework5\IView {	
	
	public function render($options = null) {
		
		# determine if sent options is correct model
		if (!get_class($options) == 'ExecutionInfo')
			throw new Framework5\Exception("ExecutionInfoView expects parameter of type ExecutionInfo");
		
		# format data
		$options->memory_peak = BytesConverter::format($options->memory_peak);
		
		# render output
		return <<<HTML

		<h2>Execution Info</h2>
			<p>start time: {$options->start_time}</p>
			<p>execution time: {$options->exec_time}</p>
			<p>memory peak: {$options->memory_peak}</p>
HTML;
	}
}