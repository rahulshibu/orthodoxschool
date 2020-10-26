<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class NewCalendarModel extends BaseModel {

	public function __construct(){
		parent::__construct();
		$this->table_name = "new_calender";
	}
	
	public function get(){
		$query = "SELECT * FROM new_calender";
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function getDetailsByMonth($month, $year){
	    if (empty($month) && empty($year)){
            $query = "SELECT * FROM new_calender order by id desc";
        }else{
            $query = "SELECT * FROM new_calender WHERE MONTH(startDate) = " . $month . " AND YEAR(startDate) = " . $year;
        }
		$record = $this->db->query($query);
		return $record;		
	}
	public function getCalenderById($id){
            $query = "SELECT * FROM new_calender where id =".$id;
		$record = $this->db->query($query);
		return $record;
	}
	public function getCalender(){
            $query = "SELECT * FROM new_calender";
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
		$query = "DELETE FROM new_calender WHERE id = " . $id;
		$this->db->query($query);		
		return True;		
	}
}

?>