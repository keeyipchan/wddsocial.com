<?php

namespace WDDSocial;

/**
* 
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class Uploader {
	public static function upload_user_avatar($image, $name){
		import('wddsocial.helper.WDDSocial\Resizer');
		$root = \Framework5\Request::root_path();
		$dest = "{$root}images/avatars";
		Resizer::image($image,$name,"_full",$dest,300,500);
		Resizer::image($image,$name,"_medium",$dest,60,60,true);
		Resizer::image($image,$name,"_small",$dest,15,15,true);
		unlink("$dest/$name");
	}
	
	public static function upload_employer_avatar($image, $name){
		import('wddsocial.helper.WDDSocial\Resizer');
		$root = \Framework5\Request::root_path();
		$dest = "{$root}images/jobs";
		Resizer::image($image,$name,"_full",$dest,300,300);
		Resizer::image($image,$name,"_medium",$dest,60,60,true);
		unlink("$dest/$name");
	}
	
	public static function upload_content_images($images, $titles, $contentID, $contentTitle, $contentType){
		$db = instance(':db');
		$admin_sql = instance(':admin-sql');
		$sel_sql = instance(':sel-sql');
		
		for ($i = 0; $i < count($images['name']); $i++) {
			if ($images['error'][$i] != 4) {
				$imageNumber = $i + 1;
				$imageTitle = ($titles[$i] == '')?"{$contentTitle} | Image $imageNumber":$titles[$i];
				
				$query = $db->prepare($admin_sql->addImage);
				$data = array(	'userID' => $_SESSION['user']->id,
								'title' => $imageTitle);
				$query->execute($data);
				
				$imageID = $db->lastInsertID();
				
				$query = $db->prepare($sel_sql->getImageFilename);
				$data = array('id' => $imageID);
				$query->execute($data);
				$query->setFetchMode(\PDO::FETCH_OBJ);
				$result = $query->fetch();
				
				switch ($contentType) {
					case 'project':
						$data = array('projectID' => $contentID, 'imageID' => $imageID);
						$query = $db->prepare($admin_sql->addProjectImage);
						break;
					case 'article':
						$data = array('articleID' => $contentID, 'imageID' => $imageID);
						$query = $db->prepare($admin_sql->addArticleImage);
						break;
					case 'event':
						$data = array('eventID' => $contentID, 'imageID' => $imageID);
						$query = $db->prepare($admin_sql->addEventImage);
						break;
					case 'job':
						$data = array('jobID' => $contentID, 'imageID' => $imageID);
						$query = $db->prepare($admin_sql->addJobImage);
						break;
				}
				$query->execute($data);
				
				$newImage = array(	'tmp_name' => $images['tmp_name'][$i],
									'type' => $images['type'][$i]);
				Uploader::upload_image($newImage,"{$result->file}");
			}
		}
	}
	
	public static function upload_image($image, $name){
		import('wddsocial.helper.WDDSocial\Resizer');
		$root = \Framework5\Request::root_path();
		$dest = "{$root}images/uploads";
		Resizer::image($image,$name,"_full",$dest,800,600);
		Resizer::image($image,$name,"_large",$dest,300,250);
		Resizer::image($image,$name,"_medium",$dest,60,60,true);
		unlink("$dest/$name");
	}
	
	public static function create_ics_file($event){
		echo "<pre>";
		echo render('wddsocial.view.WDDSocial\iCalView', array('section' => 'header'));
		echo render('wddsocial.view.WDDSocial\iCalView', array('section' => 'event', 'event' => $event));
		echo render('wddsocial.view.WDDSocial\iCalView', array('section' => 'footer'));
		echo "</pre>";
		
		/* TO DISPLAY:
		import('wddsocial.controller.WDDSocial\Uploader');
		$db = instance(':db');
		$sql = instance(':sel-sql');
		$data = array('id' => 1);
		$query = $db->prepare($sql->getEventICSValues);
		$query->setFetchMode(\PDO::FETCH_OBJ);
		$query->execute($data);
		$event = $query->fetch();
		Uploader::create_ics_file($event);
		*/
	}
}