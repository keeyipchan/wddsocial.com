<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class ContentView implements \Framework5\IView {
	
	/**
	* Determines what type of content to render
	*/
	
	public static function render($options = null) {
		import('wddsocial.helper.WDDSocial\NaturalLanguage');
		
		# retrieve content based on the provided section
		switch ($options['section']) {
			case 'overview':
				return static::overview($options['content']);
			case 'members':
				return static::members($options['content']);
			case 'media':
				return static::media($options['content'],$options['active']);
			case 'comments':
				return static::comments($options['comments']);
			default:
				throw new \Framework5\Exception("ContentView requires parameter section (overview, members, media, or comments), '{$options['section']}' provided");
		}
	}
	
	
	
	/**
	* Display content overview
	*/
	
	private static function overview($content){
		$root = \Framework5\Request::root_path();
		$html = "";
		if(\WDDSocial\UserValidator::is_current($content->userID)){
			$html .= <<<HTML

					<div class="secondary icons">
						<a href="{$root}" title="Edit &ldquo;{$content->title}&rsquo;" class="edit">Edit</a>
						<a href="{$root}" title="Delete &ldquo;{$content->title}&rsquo;" class="delete">Delete</a>
					</div><!-- END SECONDARY -->
HTML;
		}else{
			switch ($content->type) {
				case 'project':
					if(\WDDSocial\UserValidator::is_project_owner($content->id)){
						$html .= <<<HTML

					<div class="secondary icons">
						<a href="{$root}" title="Edit &ldquo;{$content->title}&rsquo;" class="edit">Edit</a>
					</div><!-- END SECONDARY -->
HTML;
					}else{
						$html .= <<<HTML

					<div class="secondary icons">
						<a href="{$root}" title="Flag &ldquo;{$content->title}&rsquo;" class="flag">Flag</a>
					</div><!-- END SECONDARY -->
HTML;
					}
					break;
				case 'article':
					if(\WDDSocial\UserValidator::is_article_owner($content->id)){
						$html .= <<<HTML

					<div class="secondary icons">
						<a href="{$root}" title="Edit &ldquo;{$content->title}&rsquo;" class="edit">Edit</a>
					</div><!-- END SECONDARY -->
HTML;
					}else{
						$html .= <<<HTML

					<div class="secondary icons">
						<a href="{$root}" title="Flag &ldquo;{$content->title}&rsquo;" class="flag">Flag</a>
					</div><!-- END SECONDARY -->
HTML;
					}
					break;
			}
		}
		if(count($content->images) > 0){
			$html .= <<<HTML

					<a href="{$root}images/uploads/{$content->images[0]->file}_full.jpg" title="{$content->images[0]->title}"><img src="{$root}images/uploads/{$content->images[0]->file}_large.jpg" alt="{$content->images[0]->title}" /></a>
					<div class="large no-margin">
HTML;
		}else{
			$html .= <<<HTML

					<div class="large">
HTML;
		}
		$html .= <<<HTML

						<h2>Description</h2>
HTML;
		
		if($content->description != ''){
			$html .= <<<HTML

						<p>{$content->description}</p>
HTML;
		}else{
			$html .= <<<HTML

						<p class="empty">No description has been added. Lame.</p>
HTML;
		}
		switch ($content->type) {
			case 'project':
				$html .= <<<HTML

						<p>Completed in {$content->completeDate}.</p>
						<p>Posted {$content->date}</p>
HTML;
				break;
			case 'article':
				$html .= <<<HTML

						<p>Written {$content->date}</p>
HTML;
				break;
		}
		$html .= <<<HTML

					</div><!-- END DESCRIPTION -->
					
					<div class="small">
						<h2>Categories</h2>
HTML;
		if(count($content->categories) > 0){
			$html .= <<<HTML

						<ul>
HTML;
			foreach($content->categories as $category){
				$html .= <<<HTML

							<li><a href="{$root}/search/{$category->title}" title="Categories | {$category->title}">{$category->title}</a></li>
HTML;
			}
			$html .= <<<HTML

						</ul>
HTML;
		}else{
			$html .= <<<HTML

						<p>No categories have been added. Such a shame...</p>
HTML;
		}
		$html .= <<<HTML

					</div><!-- END CATGORIES -->
					
					<div class="small no-margin">
						<h2>Links</h2>
HTML;
		if(count($content->links) > 0){
			$html .= <<<HTML

						<ul>
HTML;
			foreach($content->links as $link){
				$html .= <<<HTML

							<li><a href="http://{$link->link}" title="{$link->title}">{$link->title}</a></li>
HTML;
			}
			$html .= <<<HTML

						</ul>
HTML;
		}else{
			$html .= <<<HTML

						<p>No links have been added. That&rsquo;s no fun.</p>
HTML;
		}
		$html .= <<<HTML

					</div><!-- END LINKS -->
HTML;
		
		if($content->content != ''){
			$html .= <<<HTML

					<section class="content">
						<p>{$content->content}</p>
					</section><!-- END CONTENT -->
HTML;
		}
		
		return $html;
	}
	
	
	
	/**
	* Display members listing
	*/
	
	private static function members($content){
		$root = \Framework5\Request::root_path();
		$html = "";
		
		switch ($content->type) {
			case 'project':
				if(\WDDSocial\UserValidator::is_project_owner($content->id)){
					$html .= <<<HTML

					<div class="secondary icons">
						<a href="{$root}" title="Edit &ldquo;{$content->title}&rsquo;" class="edit">Edit</a>
					</div><!-- END SECONDARY -->
HTML;
				}
				break;
			case 'article':
				if(\WDDSocial\UserValidator::is_article_owner($content->id)){
					$html .= <<<HTML

					<div class="secondary icons">
						<a href="{$root}" title="Edit &ldquo;{$content->title}&rsquo;" class="edit">Edit</a>
					</div><!-- END SECONDARY -->
HTML;
				}
				break;
			default :
				if(\WDDSocial\UserValidator::is_current($content->userID)){
					$html .= <<<HTML

					<div class="secondary icons">
						<a href="{$root}" title="Edit &ldquo;{$content->title}&rsquo;" class="edit">Edit</a>
					</div><!-- END SECONDARY -->
HTML;
				}
				break;
		}
		
		if(count($content->team) > 0){
			$html .= <<<HTML

					<ul>
HTML;
			foreach($content->team as $member){
				if(\WDDSocial\UserValidator::is_current($member->id)){
					$key = array_search($member, $content->team);
					$currentUser = $content->team[$key];
					unset($content->team[$key]);
					array_unshift($content->team,$currentUser);
				}
			}
			
			foreach($content->team as $member){
				$userVerbage = \WDDSocial\NaturalLanguage::view_profile($member->id,"{$member->firstName} {$member->lastName}");
				$userDisplayName = \WDDSocial\NaturalLanguage::display_name($member->id,"{$member->firstName} {$member->lastName}");
				$userDetail = '';
				switch ($content->type) {
					case 'project':
						$userDetail = $member->role;
						break;
					default :
						$userDetail = $member->bio;
						break;
				}
				$html .= <<<HTML

						<li>
							<a href="{$root}user/{$member->vanityURL}" title="{$userVerbage}">
							<img src="{$root}images/avatars/{$member->avatar}_medium.jpg" alt="{$userDisplayName}" />
							<p><strong>{$userDisplayName}</strong> {$userDetail}</p>
							</a>
						</li>
HTML;
			}
			
			$html .= <<<HTML

					</ul>
HTML;
		}else{
			$html .= <<<HTML

					<p class="empty">No one has been added. Well, that&rsquo;s pretty lonely.</p>
HTML;
		}
		
		return $html;
	}
	
	
	
	/**
	* Display content media
	*/
	
	private static function media($content,$active){
		$root = \Framework5\Request::root_path();
		$html = <<<HTML

					<div class="$active">
HTML;
		
		switch ($active) {
			case 'images':
				if(count($content->images) > 0){
					foreach($content->images as $image){
						$html .= <<<HTML

						<a href="{$root}images/uploads/{$image->file}_full.jpg" title="{$image->title}"><img src="{$root}images/uploads/{$image->file}_large.jpg" alt="{$image->title}"/></a>
HTML;
					}
				}else{
					$html .= <<<HTML

						<p class="empty">Welp! No images have been added, so this page will look a little plain...</p>
HTML;
				}
				
				break;
			case 'videos':
				if(count($content->videos) > 0){
					foreach($content->videos as $video){
						$html .= <<<HTML

						{$video->embedCode}
HTML;
					}
				}else{
					$html .= <<<HTML

						<p class="empty">Uh oh, no videos have been added.</p>
HTML;
				}
				
				break;
		}
		
		$html .= <<<HTML

					</div><!-- END $active -->
HTML;
		
		return $html;
	}
	
	
	
	/**
	* Display content comments
	*/
	
	private static function comments($comments){
		$root = \Framework5\Request::root_path();
		$html = "";
		$commentCount = count($comments);
		$commentVerbage = 'comment';
		if($commentCount > 1 || $commentCount < 1){
			$commentVerbage .= 's';
		}
		$html .= <<<HTML

					<div class="secondary">
						<p>{$commentCount} {$commentVerbage}</p> 
					</div><!-- END SECONDARY -->
HTML;
		
		if($commentCount > 0){
			foreach($comments as $comment){
				$userVerbage = \WDDSocial\NaturalLanguage::view_profile($comment->userID,"{$comment->firstName} {$comment->lastName}");
				$userDisplayName = \WDDSocial\NaturalLanguage::display_name($comment->userID,"{$comment->firstName} {$comment->lastName}");
				
				$html .= <<<HTML

					<article class="with-secondary">
HTML;
				if(!\WDDSocial\UserValidator::is_current($comment->userID)){
					$possessive = \WDDSocial\NaturalLanguage::possessive("{$comment->firstName} {$comment->lastName}");
					$html .= <<<HTML

						<div class="secondary">
							<a href="#" title="Flag {$possessive} Comment;" class="flag">Flag</a>
						</div><!-- END SECONDARY -->
HTML;
				}
				$html .= <<<HTML
						
						<p class="item-image"><a href="{$root}user/{$comment->vanityURL}" title="{$userVerbage}"><img src="{$root}images/avatars/{$comment->avatar}_medium.jpg" alt="{$userDisplayName}"/></a></p>
						<h2><a href="{$root}user/{$comment->vanityURL}" title="{$userVerbage}">{$userDisplayName}</a></h2>
						<p>{$comment->content}</p>
						<p class="comments">{$comment->date}</p>
					</article>
HTML;
			}
		}else{
			$html .= <<<HTML

					<p class="empty">No one has commented yet, why don&rsquo;t you start the conversation?</p>
HTML;
		}
		
		if(\WDDSocial\UserValidator::is_authorized()){
			$user = $_SESSION['user'];
			$userVerbage = \WDDSocial\NaturalLanguage::view_profile($user->id,"{$user->firstName} {$user->lastName}");
			$userDisplayName = \WDDSocial\NaturalLanguage::display_name($user->id,"{$user->firstName} {$user->lastName}");
			
			$html .= <<<HTML

					<article>
						<p class="item-image"><a href="{$root}user/{$user->vanityURL}" title="{$userVerbage}"><img src="{$root}images/avatars/{$user->avatar}_medium.jpg" alt="{$userDisplayName}"/></a></p>
						<h2><a href="{$root}user/{$user->vanityURL}" title="{$userVerbage}">{$userDisplayName}</a></h2>
HTML;
			$html .= render('wddsocial.view.WDDSocial\FormView', array('type' => 'comment'));
			$html .= <<<HTML

					</article>
HTML;
		}
		
		return $html;
	}
}