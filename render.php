<?php
/**
 * Lite PHP MVC Framework
 *
 * Class Name :	Render class provides methods to render a view or response.
 * @Version	  :	Version 1.0
 */

 
class Render
{	
	var $basePath = null;
	var $htmlBodyContent = null;
	var $controller = null;
	
	public function __construct(){
		include_once("config.php");
		$this->basePath = $REWRITE_BASE_URL;
	}
	
	public function renderResponse($data, $controller = null){
		if($data != null){
			echo $data;
		}
	}
	
	public function renderView($viewInfo, $controller = null){		
		$model     = $viewInfo->model;
		$BASE_PATH = $this->basePath;
		$content   = $this->renderBody($viewInfo->view, $model);
		
		$this->htmlBodyContent = $content; // Assign the content to member variable
		if($controller != null && $controller->masterLayout != ""){
			$this->controller = $controller;
			include $controller->masterLayout; 
		} else {
			echo $content;
		}
	}
	
	public function renderHtmlBody(){
		echo $this->htmlBodyContent;
	}
	
	public function getControllerName(){
		return get_class($this->controller);
	}
	
	private function renderBody($view,$data) {
		ob_start();
		$model = $data;
		$BASE_PATH = $this->basePath;
		include $view;
		return ob_get_clean();
	}	
}

?>