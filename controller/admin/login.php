<?php

if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

@session_start();
include_once("./controller/BaseController.php");
include_once("./model/User.php");


class Login extends BaseController {

	private $model;		

	public function __construct() { 
        $this->model = new UserViewModel();
    } 
	
	public function index(){
		if(isset($_SESSION["UserSession"])) {
			$this->redirectToAnotherView('admin/dashboard/getPropertyInfoList/'); 
		}
		return $this->renderView('view/admin/login.php');
		//include_once("/../../view/admin/login.php");
	}
	
	public function signIn(){	

		$this->model->user->userName = $_POST['username'];
		$this->model->user->password = md5($_POST['password']);

		$record = $this->model->user->login();

		if(count($record) > 0) { //echo "Login Success";
			$_SESSION["UserSession"] = ["Id" => $record[0]["Id"], "UserRole" => $record[0]["UserRole"]];
			$this->redirectToAnotherView('admin/dashboard/getPropertyInfoList/');
		} else {
			$this->model->message = 'Invalid username or password';
			return $this->renderView('view/admin/login.php', $this->model);
		}
	}

	public function redirectToSomeOtherView() {
		$this->redirectToAnotherView("view/about.php");
	}
}



?>