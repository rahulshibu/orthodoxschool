<?php

// Prevent direct access to file.

if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request.');} 

@session_start();
include_once("core/HelperObjects.php");
class BaseController {

	var $masterLayout = "";
	public function __construct() {  
        $this->masterLayout = "";
    } 	
	
	protected function renderJson($data){
		header_remove("Token");
		header('Content-Type: application/json');
		return json_encode($data);
	}
	protected function rendorError($data,$code=412){
	    http_response_code($code);
		header_remove("Token");
		header('Content-Type: application/json');
        $data['isSuccess']=false;
		return json_encode($data);
	}
	
	protected function renderView($view = null, $model = null){		
		$viewInfo = new ViewInfo();	

		if($view != null){
			$viewInfo->view = $view;
		}
		if($model != null){
			$viewInfo->model = $model;
		}

		return $viewInfo;
	}

	protected function redirectToAnotherView($view){
		include_once("./config.php");
		header('Location: '.$REWRITE_BASE_URL.$view); 
	}	

	protected function convertToJson($arr) {
		$response = new stdClass;
		$response->data = $arr;
		$arr = $response;		

		if(function_exists('json_encode')) {
			return json_encode($arr); //Latest versions of PHP already has this functionality.
		}

		$parts = array();
		$is_list = false;


		//Find out if the given array is a numerical array
		$keys = array_keys($arr);
		$max_length = count($arr)-1;
		if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
			$is_list = true;
			for($i=0; $i<count($keys); $i++) { //See if each key corresponds to its position
				if($i != $keys[$i]) { //A key fails at position check.
					$is_list = false; //It is an associative array.
					break;
				}
			}
		}

		foreach($arr as $key=>$value) {
			if(is_array($value)) { //Custom handling for arrays
				if($is_list) $parts[] = array2json($value); /* :RECURSION: */
				else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
			} else {
				$str = '';
				if(!$is_list) $str = '"' . $key . '":';
				//Custom handling for multiple data types
				if(is_numeric($value)) $str .= $value; //Numbers
				elseif($value === false) $str .= 'false'; //The booleans
				elseif($value === true) $str .= 'true';
				else $str .= '"' . addslashes($value) . '"'; //All other things
				// :TODO: Is there any more datatype we should be in the lookout for? (Object?)
				$parts[] = $str;
			}
		}

		$json = implode(',',$parts);	

		if($is_list) return '[' . $json . ']';//Return numerical JSON
		return '{' . $json . '}';//Return associative JSON
	}
}

class AuthController extends BaseController {

	public function __construct() {  
		parent::__construct();
		$this->log();
		if(!$this->isAuthenticated()){
			$this->redirectToAnotherView('account/index/');
		}
    }

	public function isAuthenticated(){
		$isValid = False;
		if(isset($_GET['token'])){
			$isValid = $this->validateApiAccess();
			// TODO: Revisit this, handle the authentication (api & admin website) separate. Refactor this later
			if(!$isValid){
				header("HTTP/1.1 401 Unauthorized");
				exit;
			}
		}
		else if(isset($_SESSION["UserSession"])) { // Do session validation for admin
			$isValid = True;
		}
		return $isValid;
	}

	private function validateApiAccess(){
		$isValid = False;
		if(strlen($_GET['token']) > 0 && strlen($_GET['token'] ==  "A1BG-GH6J-YT56-ZXLK")){
			$isValid = True;
		}
		return $isValid;
	}
	
	// Gets all header values present in a request.
	private function getRequestHeaders() {
		$headers = array();
		
		foreach($_SERVER as $key => $value) {
			if (substr($key, 0, 5) <> 'HTTP_') {
				continue;
			}
			$header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
			$headers[$header] = $value;
		}
		return $headers;
	}

	private function log(){
		$file = 'log_http.txt';
		// Open the file to get existing content
		$current = file_get_contents($file);
		// Append a new person to the file
		$current .= implode(" ",$_GET);
		// Write the contents back to the file
		file_put_contents($file, $current);
	
	}
}

?>