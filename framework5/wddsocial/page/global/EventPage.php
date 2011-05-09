<?php

namespace WDDSocial;

/*
* Event Info Page
* 
* @author: Anthony Colangelo (me@acolangelo.com)
* @author Tyler Matthews (tmatthewsdev@gmail.com)
*/

class EventPage implements \Framework5\IExecutable {
	
	public function execute() {	
		
		# get event details
		$event = $this->getEvent(\Framework5\Request::segment(1));
		
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
			echo render(':template', array('section' => 'top', 'title' => "{$event->title}"));
			echo render(':section', array('section' => 'begin_content'));
			
			
			# display event overview
			echo render(':section', 
				array('section' => 'begin_content_section', 'id' => 'event', 
					'classes' => array('large', 'with-secondary'), 'header' => $event->title));
			echo render('wddsocial.view.content.WDDSocial\OverviewDisplayView', $event);
			echo render(':section', array('section' => 'end_content_section', 'id' => 'event'));
			
			
			# display event details
			echo render(':section', 
				array('section' => 'begin_content_section', 'id' => 'location', 
					'classes' => array('small', 'no-margin', 'side-sticky', 'with-secondary'), 
					'header' => 'Location and Time'));
			echo render('wddsocial.view.content.WDDSocial\EventLocationDisplayView', $event);
			echo render(':section', array('section' => 'end_content_section', 'id' => 'location'));
			
			
			# display event media
			echo render(':section', 
				array('section' => 'begin_content_section', 'id' => 'media', 
					'classes' => array('small', 'no-margin', 'side-sticky', 'with-secondary'), 
					'header' => 'Media', 'extra' => 'media_filters'));
			echo render('wddsocial.view.content.WDDSocial\MediaDisplayView', 
				array('content' => $event, 'active' => 'images'));
			echo render(':section', array('section' => 'end_content_section', 'id' => 'media'));
			
			
			# display event comments
			echo render(':section', 
				array('section' => 'begin_content_section', 'id' => 'comments', 
					'classes' => array('medium', 'with-secondary'), 'header' => 'Comments'));
			echo render('wddsocial.view.content.WDDSocial\CommentDisplayView', $event->comments);
			echo render(':section', array('section' => 'end_content_section', 'id' => 'comments'));
		}
		
		
		# event does not exist
		else {
			# display site header
			echo render(':template', array('section' => 'top', 'title' => "Event Not Found"));
			echo render(':section', array('section' => 'begin_content'));
			
			# display event not found view
			echo "<h1>Event Not Found</h1>";
		}
		
		
		# display page footer
		echo render(':section', array('section' => 'end_content'));
		echo render(':template', array('section' => 'bottom'));
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