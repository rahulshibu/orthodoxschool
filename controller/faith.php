<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/faith.php");

class Faith extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records     = [];
		$faith = new FaithModel();		
		$records["faith"] = $faith->get();
		return $this->renderView('view/faith.php', $records);
	}
	
	public function saveFaith() {
		$faith       = new FaithModel();		
		$id          = $faith->save($_POST);
		$isSuccess   = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getFaith() {
		$faith      = new FaithModel();
		$response   = $faith->get();
		return $this->renderJson($response);
	}
	
	public function getFaithDetailsById() {
		$faith      = new FaithModel();
		$response   = $faith->getFaithById($_GET["id"]);
		return $this->renderJson($response);
	}
	
	public function deleteFaith() {
		$faith      = new FaithModel();
		$response   = $faith->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>