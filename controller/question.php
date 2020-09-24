<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/question.php");
//include_once("c/m.php");
include ('./controller/Email.php');

class Question extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records       = [];
		$question = new QuestionModel();
		$records["churchHistory"] = $question->get();
		return $this->renderView('view/question.php', $records);
	}
	
	public function saveQuestion() {
		$Question = new QuestionModel();

        if (isset($_POST['sendEmail']) && $_POST['sendEmail']){
		    $_GET['id']=$_POST['id'];
		    $result =json_decode($this->getQuestionDetailsById(),true);
		    if (isset($result) && isset($result[0])){
                var_dump($result[0]);die;
                Email::sendMail($result[0]['email'],'Orthodox Bible School Question Reply',$this->emailContent($result[0]['name'],$result[0]['question'],$_POST['answer']));
            }
		    unset($_POST['sendEmail']);
        }
        var_dump($_POST);die;
		$id            = $Question->save($_POST);
		$isSuccess     = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	public function askQuestion() {
		$Question = new QuestionModel();
		if (!isset($_POST['email']) || !isset($_POST['name']) || !isset($_POST['question']) || empty($_POST['email']) || empty($_POST['name']) || empty($_POST['question'])){
		    return $this->rendorError(['error'=>"Mandatory fields required"]);
        }
		if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            return $this->rendorError(['error'=>"Invalid email"]);
        }
		$id            = $Question->save($_POST);
		$isSuccess     = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getQuestion() {
        $Question = new QuestionModel();
		$response      = $Question->get();
		return $this->renderJson($response);
	}
	
	public function getQuestionDetailsById() {
		$churchHistory = new QuestionModel();
		$response      = $churchHistory->getQuestionDetailsById($_GET["id"]);
		return $this->renderJson($response);
	}
	
	public function deleteQuestion() {
		$Question      = new QuestionModel();
		$response   = $Question->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}

	public function emailContent($name,$question,$reply){
	    $email="<!DOCTYPE html>
            <html>
            <body>

            <p>Hi ".$name.",</p>

            <p>Your question : ".$question."</p>


            <p>Reply : ".$reply."</p>


            <p>Regards,<br> Orthodox Bible School</p>



            </body>
            </html>";
	    return $email;
    }
}

?>