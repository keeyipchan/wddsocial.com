<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class JobsPageHeaderView implements \Framework5\IView {
	
	public function render($options = null) {
		foreach ($options['types'] as $url => $type) {
			$typeTitle = ucfirst($type);
			$typeClass = ($type == $options['active'])?' class="current"':'';
			$html .= <<<HTML

						<a href="/jobs/{$url}/{$options['sorter']}" title="$typeTitle Jobs"$typeClass>$typeTitle</a>
HTML;
		}
		return $html;
	}
}