<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Welcome_model', 'welcome');
	}
	
	public function index()
	{
		$greeting = $this->welcome->greeting($this->uri->segment(3));	
		$this->load->view('welcome_message', ['greeting' => $greeting]);
	}
}
