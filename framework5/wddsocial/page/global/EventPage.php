<?php

namespace WDDSocial;

/*
* Event Info Page
* 
* @author: Anthony Colangelo (me@acolangelo.com)
* @author Tyler Matthews (tmatthewsdev@gmail.com)
*/

class EventPage implements \Framework5\IExecutable {
	
	public function __construct() {
		$this->lang = new \Framework5\Lang('wddsocial.lang.page.global.EventPageLang');
	}
	
	
	
	public function execute() {	
		
		# get event details
		$event = $this->getEvent(\Framework5\Request::segment(1));
		
		if (Validator::event_has_been_flagged($event->id) or Validator::event_has_expired($event->id)) redirect("/");
		
		# handle form submission
		if (isset($_POST['submit'])){
			$response = $this->_process_form($event->id,$event->type);
			
			if ($response->status) {
				$event = null;
				$event = $this->getEvent(\Framework5\Request::segment(1));
			}
		}
		
		# if the event exists
		if ($event) {
			
			# display site header
			$page_title = $event->title;
			$content = render(':section', array('section' => 'begin_content'));
			
			
			# display event overview
			$content .= render(':section', 
				array('section' => 'begin_content_section', 'id' => 'event', 
					'classes' => array('large', 'with-secondary'), 'header' => $event->title));
			$content .= render('wddsocial.view.content.WDDSocial\OverviewDisplayView', $event);
			$content .= render(':section', array('section' => 'end_content_section', 'id' => 'event'));
			
			
			# display event details
			$content .= render(':section', 
				array('section' => 'begin_content_section', 'id' => 'location', 
					'classes' => array('small', 'no-margin', 'side-sticky', 'with-secondary'), 
					'header' => 'Location and Time'));
			$content .= render('wddsocial.view.content.WDDSocial\EventLocationDisplayView', $event);
			$content .= render(':section', array('section' => 'end_content_section', 'id' => 'location'));
			
			$media = \Framework5\Request::segment(2);
			if (isset($media) and $media != '') {
				switch ($media) {
					case 'images':
						$activeMedia = 'images';
						break;
					case 'videos':
						$activeMedia = 'videos';
						break;
					default:
						$activeMedia = 'images';
						break;
				}
			}
			else {
				$activeMedia = 'images';
			}
			
			# display event media
			$content .= render(':section', 
				array('section' => 'begin_content_section', 'id' => 'media', 
					'classes' => array('small', 'no-margin', 'side-sticky', 'with-secondary'), 
					'header' => 'Media'));
			$content .= render('wddsocial.view.content.WDDSocial\MediaDisplayView', 
				array('content' => $event, 'active' => $activeMedia, 'base_link' => "/event/{$event->vanityURL}"));
			$content .= render(':section', array('section' => 'end_content_section', 'id' => 'media'));
			
			
			# display event comments
			$content .= render(':section', 
				array('section' => 'begin_content_section', 'id' => 'comments', 
					'classes' => array('medium', 'with-secondary'), 'header' => 'Comments'));
			$content .= render('wddsocial.view.content.WDDSocial\CommentDisplayView', $event->comments);
			$content .= render(':section', array('section' => 'end_content_section', 'id' => 'comments'));
			$content .= render(':section', array('section' => 'end_content'));
		}
		
		
		# event does not exist
		else {
			$page_title = $this->lang->text('not-found-page-title');
			$content = render(':section', array('section' => 'begin_content'));
			
			# display event not found view
			$content .= "<h1>Event Not Found</h1>";
			$content .= render(':section', array('section' => 'end_content'));
		}
		
		# display page
		echo render(':template', 
			array('title' => $page_title, 'content' => $content));
	}
	
	
	
	/**
	* Gets the requested Event and data
	*/
	
	private function getEvent($vanityURL){
		
		import('wddsocial.model.WDDSocial\ContentVO');
		
		# Get db instance and query
		$db = instance(':db');
		$sql = instance(':sel-sql');
		$data = array('vanityURL' => $vanityURL);
		$query = $db->prepare($sql->getEventByVanityURL);
		$query->setFetchMode(\PDO::FETCH_CLASS,'WDDSocial\ContentVO');
		$query->execute($data);
		return $query->fetch();
	}
	
	
	
	/**
	* Handle comment addition
	*/
	
	private function _process_form($eventID,$contentType) {
		import('wddsocial.model.WDDSocial\FormResponse');
		import('wddsocial.controller.processes.WDDSocial\CommentProcessor');
		CommentProcessor::add_comment($_POST['content'],$eventID,$contentType);
		return new FormResponse(true);
	}
}