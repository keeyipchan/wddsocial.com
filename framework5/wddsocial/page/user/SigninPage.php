<?php

namespace WDDSocial;

/*
* User signin page
* 
* @author tmatthews (tmatthewsdev@gmail.com)
*/

class SigninPage implements \Framework5\IExecutable {
	
	/**
	* display signin page
	*/
	
	public function execute() {
		
		# handle form submission
		if (isset($_POST['submit'])){
			$response = $this->_process_form();
			
			# redirect user on success
			if ($response->status) {
				# redirect user to last page
				if ($_SESSION['last_page']) {
					redirect($_SESSION['last_page']);
					$_SESSION['last_page'] = null;
				}
				else {
					redirect('/');
				}
			}
		}
		
		# display site header
		echo render(':template', 
			array('section' => 'top', 'title' => 'Sign In to WDD Social'));
		
		# open content section
		echo render(':section', array('section' => 'begin_content'));
		
		# display sign in form header
		echo render('wddsocial.view.form.WDDSocial\ExtraView', array('type' => 'sign_in_intro'));
		
		# display signin form
		echo render('wddsocial.view.form.WDDSocial\SigninView', 
			array('error' => $response->message));
		
		# end content section
		echo render(':section', 
			array('section' => 'end_content'));
		
		# display site footer
		echo render(':template', array('section' => 'bottom'));
	}
	
	
	
	/**
	* Handle user signup form
	*/
	
	private function _process_form() {
		
		import('wddsocial.model.WDDSocial\FormResponse');
		
		# filter input variables
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		$password = filter_input(INPUT_POST, 'password');
		
		# validate user input
		if (!$email) {
			return new FormResponse(false, "You must enter a valid email address");
		}
		if (!$password) {
			return new FormResponse(false, "You must enter a valid password");
		}
		
		# attempt user signin
		if (UserSession::signin($email, $password)) {
			
			# check if user is verified
			if (!UserSession::check_verification()) {
				$fullsailEmail = UserSession::fullsail_email();
				UserSession::signout();
				return new FormResponse(false, 
					render('wddsocial.view.form.WDDSocial\NotVerifiedView', $fullsailEmail));
			}
			
			return new FormResponse(true);
		}
		else {
			return new FormResponse(false, 'Incorrect username or password, please try again');
		}
	}
}