<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/prayers.php");
include_once("model/prayertypesmodel.php");

class Prayer extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records     = [];
		$prayerTypes = new PrayerTypesModel();
		
		$records["prayerTypes"] = $prayerTypes->get();
		return $this->renderView('view/prayer.php', $records);
	}
	
	public function savePrayer() {
		$prayer      = new PrayerModel();		
		$id          = $prayer->save($_POST);
		$isSuccess   = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getPrayer() {
		$id       = (isset($_GET["prayerType"])) ? $_GET["prayerType"] : 0;
		$prayer   = new PrayerModel();
		$response = $prayer->get($id);
		return $this->renderJson($response);
	}
	
	public function deletePrayer() {
		$prayer    = new PrayerModel();
		$response = $prayer->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>