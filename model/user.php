<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class User extends BaseModel {
	
	public function __construct(){
		parent::__construct();
		$this->table_name = "user";
	}
	
	public function login(){
		$query = "SELECT * FROM user WHERE userName = '". $this->userName ."' AND password = '". $this->password ."'";		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	private function getCount($query) {
		$count = $this->db->query($query);
		if(count($count) > 0){
			$count = $count[0]["Count"];
		} else {
			$count = 0;
		}
		return $count;
	}
}

?>