<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/calendar.php");

class Calendar extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records  = [];
		$calendar = new CalendarModel();		
		$records["calendar"] = $calendar->get();
		return $this->renderView('view/calendar.php', $records);
	}
	
	public function saveEvent() {
		$calendar  = new CalendarModel();
		$id        = $calendar->save($_POST);
		$isSuccess = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getCalendarByMonth() {
		$calendar = new CalendarModel();
		$response = $calendar->getDetailsByMonth($_GET["month"], $_GET["year"]);
		return $this->renderJson($response);
	}
		
	public function deleteEvent() {
		$calendar      = new CalendarModel();
		$response   = $calendar->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>