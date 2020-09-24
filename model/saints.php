<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class SaintsModel extends BaseModel {
	
	public function __construct(){
		parent::__construct();
		$this->table_name = "saint";
	}
	
	public function get(){
		$query = "SELECT * FROM saint";		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function getSaintDetailsById($id=0){
		$query = "SELECT * FROM saint WHERE id=".$id;		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function save($saint){
		$id = 0;					  
		if($saint["id"] == 0){
			$saint["createdDate"] = date("Y-m-d H:i:s");
			$saint["updatedDate"] = date("Y-m-d H:i:s");
			$obj = $this->insert($saint);
			$id  = $obj["id"];
		} else {
			$id = $saint["id"];
			$saint["updatedDate"] = date("Y-m-d H:i:s");
			$this->update($saint, ["id" => $id]);
		}
		return $id;
	}
	
	public function delete($id=0){
		$query = "DELETE FROM saint WHERE id = " . $id;
		$this->db->query($query);		
		return True;		
	}
}

?>