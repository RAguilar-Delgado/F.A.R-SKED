<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load->model('Auth_model', 'auth');
	}

	public function loadPage($options = array()) {
		if(!isset($options['page']) || $options['page'] == ''){ show_404(); return; }
		if(!isset($options['title']) || $options['title'] == ''){ $options['title'] = ucfirst('Orbits'); }
		if(!isset($options['statusBar'])){ $options['statusBar'] = true; } 
		if(!isset($options['footer'])){ $options['footer'] = true; }
		if(!isset($options['data'])){ $options['data'] = NULL; }
        if(!file_exists(APPPATH.'views/'.$options['page'].'.php')){ echo show_404(); return; }
        $this->load->view('Template/template',$options);
	}
}