<?php

/*
* WDD Social: Template Language Pack
*/

class TemplateLang implements \Framework5\ILanguagePack {
	
	public static function content($id, $var) {
		switch ($id) {
			# navigation elements
			case 'people':
				return 'People';
			
			case 'projects':
				return 'Projects';
			
			case 'articles':
				return 'Articles';
			
			case 'courses':
				return 'Courses';
			
			case 'events':
				return 'Events';
			
			case 'jobs':
				return 'Jobs';
				
			# user area
			case 'search':
				return 'Search';
			
			case 'search_placeholder':
				return 'Search...';

			# user signed in
			case 'user_profile_title':
				return 'View My Profile';
			
			case 'create':
				return 'Create';
			
			case 'create_title':
				return 'Create';
			
			case 'messages':
				return 'Messages';
			
			case 'messages_title':
				return 'View My Messages';
			
			case 'account':
				return 'Account';
			
			case 'account_title':
				return 'View and Edit my Account Information';
			
			case 'signout':
				return 'Sign Out';
			
			case 'signout_title':
				return 'Sign Out of WDD Social';
			
			# 	user not signed in
			case 'signup':
				return 'Sign Up';
			
			case 'signup_title':
				return 'Sign Up for WDD Social';
			
			case 'signin':
				return 'Sign In';
			
			case 'signin_title':
				return 'Sign In for WDD Social';
			
			# footer
			case 'developer':
				return 'Developer';
			
			case 'about':
				return 'About';
			
			case 'contact':
				return 'Contact';
			
			case 'terms':
				return 'Terms';
			
			case 'privacy':
				return 'Privacy';
			
			# footer titles
			case 'developer_desc':
				return 'Developer Resources';
			
			case 'about_desc':
				return 'About Us';
			
			case 'contact_desc':
				return 'Contact Us';
			
			case 'terms_desc':
				return 'Terms of Service';
			
			case 'privacy_desc':
				return 'Privacy Policy';
			
			default:
				throw new Exception("Language pack content '$id' not found");
		}
	}
}