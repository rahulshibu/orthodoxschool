<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}
session_start();
include_once("./controller/BaseController.php");
include_once("./model/Property.php");
include_once("./model/PropertyDetails.php");
include_once("./model/AdminDashboardViewModel.php");

class Dashboard extends AuthController {
	private $model;	
	private $MAX_FILE_SIZE = 1000; //  MB
	
	public function __construct() {
		if(!$this->isAuthenticated()){
			$this->redirectToAnotherView('admin/login/index/');
		}
        $this->model = new AdminDashboardViewModel();
		$this->masterLayout = "view/templates/MainLayout.php";
    } 
	
	public function index(){
		return $this->renderView('view/admin/dashboard.php');
	}
	
	public function getPropertyInfoList(){
		$records  = null;
		$property = new Property();
		$downloadedDetails = new ObjectDetailsRequest();
		
		$filterId 		= isset($_GET["filterId"]) ? $_GET["filterId"] : 0;
		$records  		= $property->getPropertyInfoList($filterId);
		//$downloadedInfo = $downloadedDetails->getAllObjectDetailsRequest();
		
		$this->model->propertyInfoList  = $records;
		//$this->model->downloadedDetails = $downloadedInfo;
		return $this->renderView('view/admin/dashboard.php', $this->model);
	}
	
	public function save(){		
		$property = new Property();		
		if(isset($_POST['hasOffer']) && $_POST['hasOffer'] == "on") {
			$_POST['hasOffer'] = 1;
		} else {
			$_POST['hasOffer'] = 0;
		}
		if(isset($_POST['isActive']) && $_POST['isActive'] == "on") {
			$_POST['isActive'] = 1;
		} else {
			$_POST['isActive'] = 0;
		}
		$objectId = $property->save($_POST);
		$isAllTrue = $this->UploadFiles($objectId);
		if(!$isAllTrue) {
			$_SESSION["UploadFilesStatus"] = False;
		} else {
			$_SESSION["UploadFilesStatus"] = True;
		}
		$this->redirectToAnotherView('admin/dashboard/manageProperty/?id=' . $objectId);
		//$this->redirectToAnotherView('admin/dashboard/getPropertyInfoList/');
	}
	
	public function delete(){		
		$property = new Property();
		$property->delete($_GET["id"]);
		
		// Delete from its details record table
		$propertyDetails = new PropertyDetails();
		$detailsRecord   = $propertyDetails->getPropertyDetails($_GET["id"]);
		if(count($detailsRecord) > 0){
			for($index = 0;$index < count($detailsRecord); $index++){
				$fileName = $detailsRecord[$index]["Image"];
				@unlink ("Assets/images/".$fileName);
			}
		}
		$this->redirectToAnotherView('admin/dashboard/getPropertyInfoList/');
	}
	
	public function download()
	{
		$downloadedDetails = new ObjectDetailsRequest();
		$downloadedInfo = $downloadedDetails->getAllObjectDetailsRequest();
		$rows = '<table id="downloadedDetails-table" border="1">
					<tr>
						<th>TITEL</th><th>ANGEBOT</th>
						<th>NAME</th><th>EMAIL</th>
						<th>MOBIL NR.</th><th>DOWNLOAD DATUM</th>
					</tr>';
		for($index = 0;$index < count($downloadedInfo); $index++){
			$rows .= '<tr>
						  <td>'. $downloadedInfo[$index]["Title"] .'</td>
						  <td style="text-align:center;">'. $downloadedInfo[$index]["PropertyNumber"] .'</td>
						  <td>'. $downloadedInfo[$index]["Name"] .'</td>
						  <td>'. $downloadedInfo[$index]["Email"] .'</td>
						  <td>'. '&nbsp;' . $downloadedInfo[$index]["MobileNumber"] .'</td>
						  <td>'. $downloadedInfo[$index]["CreatedDate"] .'</td>
					  </tr>';
		}
		$rows .= '</table>';
		header("Content-type: application/vnd-ms-excel"); 
		header("Content-Disposition: attachment; filename=downloads-export.xls");
		echo $rows;
	}

	public function manageProperty() {
		$this->model->propertyInfo = null;
		$propId = isset($_GET["id"]) ? $_GET["id"] : 0;
		
		$this->model->enableAddEditSection = True;
		$downloadedDetails = new ObjectDetailsRequest();
		$property          = new Property();
		
		if($propId == 0){
			$this->model->nextPropertyNumber = $property->getNextPropertyNumber();			
		}
		//$downloadedInfo = $downloadedDetails->getAllObjectDetailsRequest();
		//$this->model->downloadedDetails = $downloadedInfo;
		
		if($propId > 0){ // Request for edit	
			$propertyDetails   = new PropertyDetails();
			$record  = $property->getPropertyById($propId);
			$details = $propertyDetails->getPropertyDetails($propId);
			
			$this->model->propertyInfo    = $record;
			$this->model->propertyDetails = $details;			
		}
		return $this->renderView('view/admin/dashboard.php', $this->model);
	}
	
	public function reOrderImages() {		
		$propertyDetails     = new PropertyDetails();
		for($index=0;$index < count($_POST["Id"]); $index++){
			$propertyDetails->setSortOrder($_POST["Id"][$index], $index + 1);
		}
		return '{"isSuccess" : true}';
	}
	
	public function deleteImage(){
		$id       = $_GET["id"];
		$fileName = $_GET["fileName"];
		
		$propertyDetails = new PropertyDetails();
		$isDeleted       = $propertyDetails->delete($id);
		if($isDeleted){
			$details  = $propertyDetails->getPropertyDetailsById($id);					
			$fileName = $details[0]["Image"];			
			unlink ("Assets/images/".$fileName);
		}
		return "{ 'isSuccess' : 'true' }";
	}	
	
	private function UploadFiles($objectId) {//echo getcwd();
		$boolArray = [];
		$canUploadFiles   = False;
		$propDetails = new PropertyDetails();
		$propDetails->updateAllowSettings($objectId, $_POST["allowDisplay"], $_POST["allowDownload"]);
		
		$imageFiles = $propDetails->getPropertyDetails($objectId);
		$currentSize = $this->getCurrentImageFilesSize($imageFiles);		
		$canUploadFiles = ($currentSize < $this->MAX_FILE_SIZE);
			
		if(isset($_FILES['file_array']) && $canUploadFiles){
			$errors    = array();
			$index     = 0;
			$sortOrder = 0;
			
			$lastInsertedDetails = $propDetails->getLastInsertedDetailsById($objectId);			
			if(count($lastInsertedDetails) > 0) {
				$sortOrder = $lastInsertedDetails[0]["SortOrder"];
			}
			
			foreach($_FILES['file_array']['tmp_name'] as $key => $tmp_name ){
				$index++;
				$sortOrder++;
				$file_name = $key.$_FILES['file_array']['name'][$key];
				$file_size = $_FILES['file_array']['size'][$key];
				$file_tmp  = $_FILES['file_array']['tmp_name'][$key];
				$file_type = $_FILES['file_array']['type'][$key];	
				
				$desired_dir="Assets/images/";
				
				// Restrict the file upload to the size specified (10MB)
				$uploadedFileSize =  round($file_size / 1048576, 4);
				if(($currentSize + $uploadedFileSize) < $this->MAX_FILE_SIZE){
					$currentSize += $uploadedFileSize;
					$canUploadFiles = True;
					//echo $currentSize. "<br/>";
					array_push($boolArray, True);
				}
				else {
					$canUploadFiles = False;
					array_push($boolArray, False);
				}
				
				if(empty($errors)==true && $file_size > 0 && $canUploadFiles){
					$file_name_to_save = "";
					if(is_dir($desired_dir)==false){
						mkdir("$desired_dir", 0700);		// Create directory if it does not exist
					}
					if(is_dir("$desired_dir/".$file_name)==false){
						$ext = substr(strrchr($file_name,'.'),1);
						$file_name_to_save = $file_name."_".$objectId.$index.time().".".$ext;
						move_uploaded_file($file_tmp,"$desired_dir/".$file_name_to_save);
					}else{									// rename the file if another one exist
						$new_dir="$desired_dir/".$file_name.time();
						rename($file_tmp,$new_dir) ;				
					}
					$propDetails->save(["ObjectId" => $objectId, "Image" => $file_name_to_save, "SortOrder" => $sortOrder]);
				}else{
					// print_r($errors);
				}
			}
			if(empty($error)){
				//echo "Success";
			}
		} else {
			$boolArray = [False];
		}
		$isUploaded = $this->isAllTrue($boolArray);
		return $isUploaded;
	}
	
	private function isAllTrue($arr) {
		foreach($arr as $value) {
			if(!$value)	{
				return False;
			}
		}
		return True;
	}
	
	private function getCurrentImageFilesSize($imageFiles)	{
		$currentFileSize = 0;
		for($index=0;$index<count($imageFiles);$index++) {
			$currentFileSize += $this->getFileSize(@$BASE_PATH."Assets/images/".$imageFiles[$index]["Image"],"MB");
		}
		//echo "<br/>" . $currentFileSize . "<br/>";
		return $currentFileSize;
	}
	
	function getFileSize($file, $type)	{
	   switch($type){
		  case "KB":
			 $filesize = filesize($file) * .0009765625; // bytes to KB
		  break;
		  case "MB":
			 $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
		  break;
		  case "GB":
			 $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
		  break;
	   }
	   if($filesize <= 0){
		  return $filesize = 0;}
	   else{return round($filesize, 2);}
	}
}

?>