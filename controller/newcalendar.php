<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/newcalendar.php");

class NewCalendar extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records  = [];
		$calendar = new NewCalendarModel();
		$records["calendar"] = $calendar->get();
		return $this->renderView('view/newcalendar.php', $records);
	}
	
	public function saveEvent() {
		$calendar  = new NewCalendarModel();
		$id        = $calendar->save($_POST);
		$isSuccess = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getCalendarByMonth() {
		$calendar = new NewCalendarModel();
		$response = $calendar->getDetailsByMonth($_GET["month"], $_GET["year"]);
		return $this->renderJson($response);
	}
	public function getCalender() {
		$calendar = new NewCalendarModel();
		$response = $calendar->getCalender();
		return $this->renderJson($response);
	}

    public function getCalenderById() {
        $calendar = new NewCalendarModel();
        $response = $calendar->getCalenderById($_GET["id"]);
        return $this->renderJson($response);
    }
	public function deleteEvent() {
		$calendar      = new NewCalendarModel();
		$response   = $calendar->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>