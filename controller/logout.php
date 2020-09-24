<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

@session_start();
include_once("basecontroller.php");

class Logout extends BaseController {	
	
	public function __construct() {  
       
    } 	
	public function index(){
		@session_destroy();
		$this->redirectToAnotherView('account/index/');	
	}
}

?>