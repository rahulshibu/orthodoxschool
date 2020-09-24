<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class PrayerModel extends BaseModel {
	
	public function __construct(){
		parent::__construct();
		$this->table_name = "prayer";
	}
	
	public function get($id=0){
		$condition = "";
		if($id > 0){
			$condition = " WHERE p.prayerType = " . $id;
		}
		$query  = "SELECT p.*, pt.prayerType as prayerTypeText FROM prayer p INNER JOIN prayertype pt ON pt.id = p.prayerType";
		$query .= $condition;
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function save($prayer){
		$id = 0;
		$prayerData = [ 
						"id"          => $prayer["id"], 
						"prayerType"  => $prayer["prayerTypeId"], 
						"prayer"      => $prayer["prayer"],
						"createdDate" => NULL,
						"updatedDate" => NULL
					  ];
					  
		if($prayerData["id"] == 0){
			$prayerData["createdDate"] = date("Y-m-d H:i:s");
			$prayerData["updatedDate"] = date("Y-m-d H:i:s");
			$obj = $this->insert($prayerData);
			$id  = $obj["id"];
		} else {
			$id = $prayerData["id"];
			unset($prayerData["createdDate"]); // unset this key since we dont need to update created date as NULL
			$prayerData["updatedDate"] = date("Y-m-d H:i:s");
			$this->update($prayerData, ["id" => $id]);
		}
		return $id;
	}
	
	public function delete($id=0){
		$query = "DELETE FROM prayer WHERE id = " . $id;
		$this->db->query($query);		
		return True;		
	}
}

?>