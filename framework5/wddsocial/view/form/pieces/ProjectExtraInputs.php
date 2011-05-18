<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class ProjectExtraInputs implements \Framework5\IView {		
	
	public function render($options = null) {
		if (isset($options['data'])) {
			$dateValue = ($options['data']->completeDateInput == '0000-00-00')?'':$options['data']->completeDateInput;
		}
		else {
			$dateValue = date('Y-m-d');
		}
		return <<<HTML

						<fieldset>
							<label for="completed-date">When was this project completed?</label>
							<input type="text" name="completed-date" id="completed-date" value="{$dateValue}" />
							<small>yyyy-mm-dd</small>
						</fieldset>
HTML;
	}
}