<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/saints.php");

class Saint extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records     = [];
		$saint = new SaintsModel();		
		$records["saint"] = $saint->get();
		return $this->renderView('view/saint.php', $records);
	}
	
	public function saveSaint() {
		$saint       = new SaintsModel();		
		$id          = $saint->save($_POST);
		$isSuccess   = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getSaint() {
		$saint      = new SaintsModel();
		$response   = $saint->get();
		return $this->renderJson($response);
	}
	
	public function getSaintDetailsById() {
		$saint      = new SaintsModel();
		$response   = $saint->getSaintDetailsById($_GET["id"]);
		return $this->renderJson($response);
	}
	
	public function deleteSaint() {
		$saint      = new SaintsModel();
		$response   = $saint->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>