<?php

/**
 * Lite PHP MVC Framework
 *
 * Class Name :	Route class provides methods to add the urls, route the http request
 *				after performing a url match to respective controller and action methods
 * @Version	  :	Version 1.0
 */
 
include_once("render.php");
class Route
{
	private $_uri_list = array();
	private $_base_controller_dir = "./controller/";
		
	public function __construct(){
	}

	/**
	 * Description : Builds a collection of url's for url matching when http request is processed.
	 *
	 * @access	public
	 * @param	$uri              : type -> string, description -> the controller to be called.
	 * @param	$method[Optional] : type -> string, description -> the controller method to be invoked.
	 *							    if nothing is specified the default method will be "index".
	 * @param	$url_attributes   : type -> string array, description -> the attributes of the url.
	 * Exception : Raise error if duplicate url's are defined.
	 * @return	void
	 */

	public function add($uri, $method = "index", $url_attributes = [ "httpVerb" => "any" ])	{
		$uri_value = trim($uri).$method;		

		if(!array_key_exists($uri_value, $this->_uri_list)){
			$uri_value = $uri_value.'/';
			$uri_value = str_replace("//","/",$uri_value);
			$this->_uri_list[strtolower($uri_value)] = $url_attributes;
		} else {
			// Key already exist
			throw new Exception('Invalid Url entry. The url "'.$uri_value."' is already added.");
		}
		//echo "<pre>";
		//print_r($this->_uri_list);
	}

	/**
	 * Description : Routes the http request to appropriate controller and action methods and the
	 *				 response is handled over to render module for rendering.
	 *
	 * @access	public	 
	 * @return	void
	 */

	public function process() {
		$urlGetParam = isset($_GET['uri']) ? '/' . $_GET['uri'] : '/';
		$urlGetParam = strtolower($urlGetParam);
				
		// Parse optional parameter if exist. For eg: url like http://xyz.com/24 
		// Here 24 is the optional parameter, so a query string with id = 24 will be generated.
		if(!isset($_GET["id"])){
			$request_uri = $urlGetParam;
			$lastIndex = strripos($request_uri, '/');			
			$url_substr = trim(substr($request_uri , $lastIndex+1, strlen($request_uri)));			
			if(is_numeric($url_substr)){
				$_GET["id"] = $url_substr;
			}
			// Remove the optional parameter present in the url string for regex mathch.
			$urlGetParam = substr($urlGetParam , 0, $lastIndex + 1);
		}		
		
		if($urlGetParam == '/'){
			// Routes to the default page,it routes to the first search value.
			foreach ($this->_uri_list as $key => $value) {
				$ifExist = array_key_exists('default', $value);
				if($ifExist && $value['default']) { // if exist and default = True
					$urlGetParam = $key; 
					break;
				}
			}
		}

		//echo "$urlGetParam<br/><pre>";
		//print_r($this->_uri_list);
		if(array_key_exists($urlGetParam, $this->_uri_list)) {			

			if($this->IsValidHttpRequest($urlGetParam)) {	
				$urlAttributes = $this->_uri_list[$urlGetParam];
				// Create the correct url from short one specified.
				if(array_key_exists('url', $urlAttributes) && array_key_exists('method', $urlAttributes)) {
					$urlGetParam = $urlAttributes['url'].$urlAttributes['method'].'/';	
				}				

				$url_splits = explode("/",$urlGetParam);
				$url_splits = array_values(array_filter($url_splits));
							

				$controller_include_path = "";	// File path
				$method     = $url_splits[count($url_splits) - 1];
				$controller = $url_splits[count($url_splits) - 2];			

				// print_r($url_splits);
				// Build the controller include path
				foreach($url_splits as $val) {
					if($val != $method) {
						$controller_include_path .= '/'.$val;
					}
				}
				//echo $controller_include_path."<br>";
				//echo $method;				

				include_once($this->_base_controller_dir.trim($controller_include_path).".php");	
				$ctrl       = new $controller();
				$returnData = $ctrl->$method();
				$render		= new Render();			

				if($this->isViewInfoType($returnData)){
					$render->renderView($returnData, $ctrl);
				} else {
					$render->renderResponse($returnData, $ctrl);
				}
			} else {
				echo "<h1>Invalid http verb request.<br/>Please verify the http verb configured for the uri.</h1>";
			}
		} else {
			echo "<h1>The resource you are trying to access doesn't exist.</h1>";
		}
	}	

	

	// Validates the Http verb against a url.

	private function IsValidHttpRequest($url){

		$isValid        = False;

		$request_type   = $_SERVER['REQUEST_METHOD'];

		$url_attributes = $this->_uri_list[$url];

				

		if(strtolower($url_attributes["httpVerb"]) == "any"){

			$isValid = True;

		} else if (strtolower($url_attributes["httpVerb"]) == strtolower($request_type)){

			$isValid = True;

		} else {

			$isValid = False;

		}

		return $isValid;

	}

	

	private function isViewInfoType($obj){

		return is_a($obj, "ViewInfo");

	}

}



?>