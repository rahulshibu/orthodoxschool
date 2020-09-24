<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class CalendarModel extends BaseModel {
	
	public function __construct(){
		parent::__construct();
		$this->table_name = "calendar";
	}
	
	public function get(){
		$query = "SELECT * FROM calendar";		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function getDetailsByMonth($month, $year){
		$query = "SELECT * FROM calendar WHERE MONTH(startTime) = " . $month . " AND YEAR(startTime) = " . $year;		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function save($calendar){
		$id = 0;					  
		if($calendar["id"] == 0){
			$obj = $this->insert($calendar);
			$id  = $obj["id"];
		} else {
			$id = $calendar["id"];
			$this->update($calendar, ["id" => $id]);
		}
		return $id;
	}
	
	public function delete($id=0){
		$query = "DELETE FROM calendar WHERE id = " . $id;
		$this->db->query($query);		
		return True;		
	}
}

?>