<?php

namespace WDDSocial;

/*
* 
* @author tmatthews (tmatthewsdev@gmail.com)
*/

class PeoplePage implements \Framework5\IExecutable {
	
	public function execute() {
		
		# display site header
		echo render('wddsocial.view.WDDSocial\TemplateView', 
			array('section' => 'top', 'title' => 'People'));
		
		
		# display site footer
		echo render('wddsocial.view.WDDSocial\TemplateView', 
			array('section' => 'bottom'));
		
	}
}