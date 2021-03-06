<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class StudentDetailInputs implements \Framework5\IView {		
	
	public function render($options = null) {
		$now = date('F, Y');
		$campusSelected = ($options['location'] == 'on-campus')?' checked':'';
		$onlineSelected = ($options['location'] == 'online')?' checked':'';
		
		return <<<HTML

						<fieldset>
							<label for="start-date">When did you start Full Sail?</label>
							<input type="text" name="start-date" id="start-date" value="{$options['startDate']}" />
							<small>Example: <strong>$now</strong></small>
						</fieldset>
						<fieldset class="radio">
							<label for="degree-location">Degree Location</label>
							<div>
								<input type="radio" id="on-campus" name="degree-location" value="on-campus"{$campusSelected} />
								<label for="on-campus">On-Campus</label>
								
								<input type="radio" id="online" name="degree-location" value="online"{$onlineSelected} />
								<label for="online">Online</label>
							</div>
						</fieldset>
HTML;
	}
}