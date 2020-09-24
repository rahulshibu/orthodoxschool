<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class PrayerTypesModel extends BaseModel {
	
	public function __construct(){
		parent::__construct();
		$this->table_name = "prayertype";
	}
	
	public function get(){
		$query = "SELECT * FROM prayertype";
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function save($prayerType){
		$id = 0;
		//var_dump($prayerType);
		if($prayerType["id"] == 0){
			$obj = $this->insert($prayerType);
			$id  = $obj["id"];
		} else {
			$id = $prayerType["id"];
			$this->update($prayerType, ["id" => $id]);
		}
		return $id;
	}
	
	public function delete($id=0){		
		$query = "DELETE FROM prayertype WHERE id = " . $id;
		echo $query;
		$this->db->query($query);		
		return True;		
	}
}

?>