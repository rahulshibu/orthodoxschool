<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/notification.php");
include_once("fcm.php");
//require __DIR__ . '../vendor/autoload.php';


class Notification extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records       = [];
		$churchHistory = new NotificationModel();
		$records["churchHistory"] = $churchHistory->get();
		return $this->renderView('view/notification.php', $records);
	}
	
	public function saveNotification() {
		$faq = new NotificationModel();
		$id            = $faq->save($_POST);
		$isSuccess     = ($id > 0);
		$payload = ['news_id'=>$id,'description'=>$_POST['description'],'title'=>$_POST['title']];
        $data = ['body'=>$_POST['description'],'title'=>$_POST['title'],'data'=>['news_id'=>$id],'payload'=>$payload];

        if ($_POST['id']<=0)
            FCM::pushNotification($data);

        return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getNotification() {
//	    var_dump(123);die;
        $faq = new NotificationModel();
		$response      = $faq->get();
		return $this->renderJson($response);
	}
	
	public function getNotificationDetailsById() {
		$churchHistory = new NotificationModel();
		$response      = $churchHistory->getDetailsById($_GET["id"]);
		return $this->renderJson($response);
	}
	public function getNotificationById() {
		$churchHistory = new NotificationModel();
		$response      = $churchHistory->getDetailsById($_GET["news_id"]);
		return $this->renderJson($response);
	}
	
	public function deleteNotification() {
		$faq      = new NotificationModel();
		$response   = $faq->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}

}

?>