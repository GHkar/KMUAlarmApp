<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: text/html; charset=UTF-8");
class test extends CI_Controller{

	public function send_mail(){
		

		$this->load->library('email');
		$this->email->from('roruke8990@gmail.com', 'Ryan');
		$this->email->to('roruke8990@gmail.com'); 
		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.');	
		$this->email->send();
		echo $this->email->print_debugger();
	}
}
?>