<?php defined('BASEPATH') or die('No direct script access.');

class Auth_model extends CI_Model{
    public function __construct(){
        parent::__construct();
	}

	public function check_login($redirect = true){
		$loggedIn = '';
		$currenturl = current_url();
		if($this->session->userid > 0){
			$loggedIn = true;
		} else {
			$loggedIn = false;
		}

		if(!$redirect){
			return $loggedIn;
		}
		
		if($loggedIn && $currenturl == 'http://vas.cis.valpo.edu/index.php'){
			redirect("http://vas.cis.valpo.edu/~depsked/Home/home_page");
		}

		if(!$loggedIn && $currenturl != 'http://vas.cis.valpo.edu/index.php'){
			redirect("http://vas.cis.valpo.edu/~depsked");
		}

	}
}