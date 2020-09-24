<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class FaithModel extends BaseModel {
	
	public function __construct(){
		parent::__construct();
		$this->table_name = "faith";
	}
	
	public function get(){
		$query = "SELECT id, faith, description FROM faith";		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function getFaithById($id){
		$query = "SELECT id, faith, description,updatedDate FROM faith WHERE id=".$id;		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function save($faith){
		$id = 0;					  
		if($faith["id"] == 0){
			$faith["createdDate"] = date("Y-m-d H:i:s");
			$faith["updatedDate"] = date("Y-m-d H:i:s");
			$obj = $this->insert($faith);
			$id  = $obj["id"];
		} else {
			$id = $faith["id"];
			$faith["updatedDate"] = date("Y-m-d H:i:s");
			$this->update($faith, ["id" => $id]);
		}
		return $id;
	}
	
	public function delete($id=0){
		$query = "DELETE FROM faith WHERE id = " . $id;
		$this->db->query($query);		
		return True;		
	}
}

?>