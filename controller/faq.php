<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
//include_once("model/churchhistory.php");
include_once("model/faq.php");

class Faq extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records       = [];
		$churchHistory = new FaqModel();
		$records["churchHistory"] = $churchHistory->get();
		return $this->renderView('view/faq.php', $records);
	}
	
	public function saveFAQ() {
		$faq = new FaqModel();
		$id            = $faq->save($_POST);
		$isSuccess     = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getFAQ() {
//	    var_dump(123);die;
        $faq = new FaqModel();
		$response      = $faq->get();
		return $this->renderJson($response);
	}
	
	public function getFAQDetailsById() {
		$churchHistory = new FaqModel();
		$response      = $churchHistory->getfaqDetailsById($_GET["id"]);
		return $this->renderJson($response);
	}
	
	public function deleteFAQ() {
		$faq      = new FaqModel();
		$response   = $faq->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>