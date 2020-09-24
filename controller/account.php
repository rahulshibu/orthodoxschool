<?php

if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

@session_start();
include_once("./controller/basecontroller.php");
//include_once("./model/User.php");
include_once("model/user.php");


class Account extends BaseController {

	private $model;		

	public function __construct() { 
        $this->model = new User();
    } 
	
	public function index(){
		if(isset($_SESSION["UserSession"])) {
			$this->redirectToAnotherView('prayertypes/index/');
		}
		return $this->renderView('view/login.php');
	}
	
	public function login(){
		$this->model->userName = $_POST['username'];
		$this->model->password = md5($_POST['password']);

		$record = $this->model->login();
		if(count($record) > 0) { 
			$_SESSION["UserSession"] = ["Id" => $record[0]["id"], "UserRole" => 1];
			$this->redirectToAnotherView('prayertypes/index/');
		} else {
			$this->model->message = 'Invalid username or password';
			return $this->renderView('view/login.php', $this->model);
		}
	}

	public function redirectToSomeOtherView() {
		$this->redirectToAnotherView("view/about.php");
	}
}



?>