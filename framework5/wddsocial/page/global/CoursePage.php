<?php

namespace WDDSocial;

/*
* 
* @author tmatthews (tmatthewsdev@gmail.com)
*/

class CoursePage implements \Framework5\IExecutable {
	
	public function __construct() {
		$this->lang = new \Framework5\Lang('wddsocial.lang.page.global.CoursePageLang');
	}
	
	
	
	public function execute() {
		$content = " ";
		
		echo render(':template', 
			array('title' => $this->lang->text('page-title'), 'content' => $content));
	}
}