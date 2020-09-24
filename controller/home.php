<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
//include_once("model/Property.php");

class Home extends BaseController {
	private $model;	
	
	public function __construct() {  
        $this->model        = NULL;
		$this->masterLayout = "";
		if(isset($_SESSION["UserSession"])) {
			$this->redirectToAnotherView('prayertypes/index/');
		}
    } 
	
	public function index() {
		$records = NULL;
		return $this->renderView('view/login.php', $records);
	}
}

?>