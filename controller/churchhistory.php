<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/churchhistory.php");

class ChurchHistory extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records       = [];
		$churchHistory = new ChurchHistoryModel();		
		$records["churchHistory"] = $churchHistory->get();
		return $this->renderView('view/history.php', $records);
	}
	
	public function saveChurchHistory() {
		$churchHistory = new ChurchHistoryModel();		
		$id            = $churchHistory->save($_POST);
		$isSuccess     = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getChurchHistory() {
		$churchHistory = new ChurchHistoryModel();
		$response      = $churchHistory->get();
		return $this->renderJson($response);
	}
	
	public function getChurchHistoryDetailsById() {
		$churchHistory = new ChurchHistoryModel();
		$response      = $churchHistory->getChurchHistoryDetailsById($_GET["id"]);
		return $this->renderJson($response);
	}
	
	public function deleteChurchHistory() {
		$churchHistory      = new ChurchHistoryModel();
		$response   = $churchHistory->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>