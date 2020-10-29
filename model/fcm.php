<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class FCMModel extends BaseModel {
	
	public function __construct(){
		parent::__construct();
		$this->table_name = "fcm";
	}

	public function get(){
		$query = "SELECT * FROM fcm order by id desc";
		$record = $this->db->query($query);
		return $record;
	}

	public function getDetailsById($id=0){

		$query = "SELECT * FROM fcm WHERE fcm= '".$id."'";
		$record = $this->db->query($query);
		return $record;
	}

	public function save($history){
		$id = 0;
		if($history["id"] == 0){
			$history["createdDate"] = date("Y-m-d H:i:s");
			$history["updatedDate"] = date("Y-m-d H:i:s");
			$obj = $this->insert($history);
			$id  = $obj["id"];
		} else {
			$id = $history["id"];
			$history["updatedDate"] = date("Y-m-d H:i:s");
			$this->update($history, ["id" => $id]);
		}
		return $id;
	}

	public function delete($id){
		$query = "DELETE FROM fcm WHERE id in (" . $id.")";
		$this->db->query($query);
		return True;
	}
}

?>