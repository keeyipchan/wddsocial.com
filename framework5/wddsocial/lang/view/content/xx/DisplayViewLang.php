<?php

/*
* WDD Social: Language Pack for 
*/

class DisplayViewLang implements \Framework5\ILanguagePack {
	
	
	public static function content($id, $var) {
		switch ($id) {
			
			# general
			case 'edit':
				return 'XX'; # Edit
			
			case 'edit_title':
				return "XX {$var}"; # Edit &ldquo;{$var}&rdquo;
			
			case 'delete':
				return 'XX'; # Delete
			
			case 'delete_title':
				return "XX {$var}"; # Delete &ldquo;{$var}&rdquo;
			
			case 'flag':
				return 'XX'; # Flag
			
			case 'flag_title':
				return "XX {$var}"; # Flag &ldquo;{$var}&rdquo;
			
			case 'comments':
				if ($var == '1') return "{$var} XX"; # {$var} comment
				return "{$var} XX"; # {$var} comments
			
			case 'comments_title':
				return "{$var} | XX"; # {$var} | Comments
			
			case 'edit_comment':
				return ""; # Edit Comment on &ldquo;{$var}&rdquo;
			
			case 'delete_comment':
				return ""; # Delete Comment on &ldquo;{$var}&rdquo;
			
			case 'flag_comment':
				return "XX {$var}"; # Flag Comment on &ldquo;{$var}&rdquo;
			
			case 'posted_a':
				return 'XX'; # posted a
			
			case 'wrote_an':
				return 'XX'; # wrote an
			
			case 'project':
				return 'XX'; # project
			
			case 'article':
				return 'XX'; # article
			
			case 'category_title':
				return "XX | {$var}"; # Categories | {$var}
			
			case 'joined':
				return 'XX'; # joined the community
			
			case 'and':
				return 'XX'; # and
			
			case 'download_ical':
				return "XX {$var}"; # Download {$var} iCal File
			
			case 'ical':
				return 'XX'; # iCal
			
			case 'search_maps':
				return "XX {$var}"; # Search Google Maps for {$var}
			
			case 'see_all_jobs':
				return "XX {$var}"; # See {$var} Job Postings
		}
	}
}