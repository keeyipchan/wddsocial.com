<?php

namespace WDDSocial;

/*
* 
* @author tmatthews (tmatthewsdev@gmail.com)
*/

class SignoutPage implements \Framework5\IExecutable {
	
	public function execute() {
		UserSession::signout();
		redirect('/');
	}
}