<?php

namespace WDDSocial;

/*
* 
* @author Anthony Colangelo (me@acolangelo.com)
*/

class SignupView implements \Framework5\IView {		
	
	public function render($options = null) {
		$html = <<<HTML

					<form action="/signup" id="signup" method="post" enctype="multipart/form-data">
						<p class="error"><strong>{$options['error']}</strong></p>
						<fieldset>
							<label for="first-name">First Name</label>
							<input type="text" name="first-name" id="first-name" value="{$_POST['first-name']}" autofocus />
						</fieldset>
						<fieldset>
							<label for="last-name">Last Name</label>
							<input type="text" name="last-name" id="last-name" value="{$_POST['last-name']}" />
						</fieldset>
						<fieldset>
							<label for="email">Primary Email</label>
							<input type="email" name="email" id="email" value="{$_POST['email']}" />
							<small>Used for contacting you</small>
						</fieldset>
						<fieldset>
							<label for="full-sail-email">Full Sail Email</label>
							<input type="email" name="full-sail-email" id="full-sail-email" value="{$_POST['full-sail-email']}" />
							<small>Used for account verification</small>
						</fieldset>
						<fieldset>
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="check-length" />
							<small>6 or more characters</small>
						</fieldset>
HTML;
		$html .= render('wddsocial.view.form.pieces.WDDSocial\UserTypeSelector', array('typeID' => 1));
		$html .= <<<HTML

						<fieldset class="terms">
							<label for="terms">Boring Legal Stuff</label>
							<p><input type="checkbox" name="terms" id="terms" /><label for="terms" class="plain">I have read and agree to the <a href="#terms-content" title="WDD Social Terms of Service" id="terms-link" tabindex="1000">Terms of Service</a>.</label></p>
						</fieldset>
HTML;
		require_once '../framework5/wddsocial/helper/recaptchalib.php';
		$publickey = "6Lfu6sQSAAAAAJbZCeNyocJviy5TJTZZIifBgoBz";
		$html .= recaptcha_get_html($publickey);
		$html .= <<<HTML

						 <script type="text/javascript"
					       src="http://www.google.com/recaptcha/api/challenge?k=6Lfu6sQSAAAAAJbZCeNyocJviy5TJTZZIifBgoBz">
					    </script>
					    <noscript>
					       <iframe src="http://www.google.com/recaptcha/api/noscript?k=6Lfu6sQSAAAAAJbZCeNyocJviy5TJTZZIifBgoBz" frameborder="0"></iframe><br>
					       <textarea name="recaptcha_challenge_field" rows="3" cols="40">
					       </textarea>
					       <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
					    </noscript>
						<p class="helper-link"><a href="/signin" title="Already a WDD Social member?" tabindex="1000">Already a member?</a></p>
						<input type="submit" name="submit" value="Sign Up" />
					</form>
					<section id="terms-holder">
						<div id="terms-content">
HTML;
		$html .= render('wddsocial.view.content.WDDSocial\TermsOfService');
		$html .= <<<HTML

						</div>
					</section>
HTML;
		return $html;
	}
}