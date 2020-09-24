<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/biblewords.php");

class BibleWords extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    } 
	
	public function index() {
		$records     = [];
		$bibleWords = new BibleWordsModel();
		
		$records["biblewords"] = $bibleWords->get();
		return $this->renderView('view/biblewords.php', $records);
	}
	
	public function saveBibleWords() {
		$bibleWords  = new BibleWordsModel();		
		$id          = $bibleWords->save($_POST);
		$isSuccess   = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
	}
	
	public function getBibleWords() {
		$bibleWords = new BibleWordsModel();
		$response   = $bibleWords->get();
		return $this->renderJson($response);
	}
	
	public function getBibleWordThoughts() {
		$bibleWords = new BibleWordsModel();
		$response   = $bibleWords->getBibleWordThoughts($_GET["id"]);
		return $this->renderJson($response);
	}
	
	public function deleteBibleWords() {
		$bibleWords = new BibleWordsModel();
		$response   = $bibleWords->delete($_GET["id"]);
		return $this->renderJson(["isSuccess" => $response]);
	}
}

?>