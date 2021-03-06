<?php

/*
* WDD Social: Language Pack for CoursesPage
* Language: en
*/

class CoursesPageLang implements \Framework5\ILanguagePack {
	
	
	public static function content($id, $var) {
		switch ($id) {
			
			case 'page-title':
				return 'Courses';
			
			case 'page-header':
				return 'Courses';
			
			
			# content sorters
			case 'sort-month':
				return 'month';
			
			case 'sort-alphabetically':
				return 'alphabetically';
			
			default:
				throw new Exception("Language pack content '$id' not found");
		}
	}
}