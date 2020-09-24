<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/prayertypesmodel.php");

class PrayerTypes extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records = NULL;
		return $this->renderView('view/prayertypes.php', $records);
	}
	
	public function savePrayerType() {
		$types       = new PrayerTypesModel();
		//$_POST["id"] = (isset($_POST["prayerTypeId"])) ? $_POST["prayerTypeId"] : 0;
		
		// Remove the unwanted POST button data
		// Removing this from POST array since its already replaced with Id
		//unset($_POST["prayerTypeId"]); 
		//unset($_POST["Save"]);
		
		$id          = $types->save($_POST);
		$isSuccess   = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getPrayerTypes() {
		$types    = new PrayerTypesModel();
		$response = $types->get();
		return $this->renderJson($response);
	}
	
	public function deletePrayerTypes() {
		$types    = new PrayerTypesModel();
		$response = $types->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>