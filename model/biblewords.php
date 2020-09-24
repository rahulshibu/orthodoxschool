<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('basemodel.php');

class BibleWordsModel extends BaseModel {
	
	public function __construct(){
		parent::__construct();
		$this->table_name = "biblewords";
	}
	
	public function get(){
		$query = "SELECT id, portion, bibleWords, description FROM biblewords";		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function getBibleWordThoughts($id){
		$query = "SELECT portion, bibleWords, description, updatedDate FROM biblewords WHERE id = ". $id;		
		$record = $this->db->query($query);		
		return $record;		
	}
	
	public function save($bibleWords){
		$id = 0;
					  
		if($bibleWords["id"] == 0){
			$bibleWords["createdDate"] = date("Y-m-d H:i:s");
			$bibleWords["updatedDate"] = date("Y-m-d H:i:s");
			$obj = $this->insert($bibleWords);
			$id  = $obj["id"];
		} else {
			$id = $bibleWords["id"];
			//unset($bibleWords["createdDate"]); // unset this key since we dont need to update created date as NULL
			$bibleWords["updatedDate"] = date("Y-m-d H:i:s");
			$this->update($bibleWords, ["id" => $id]);
		}
		return $id;
	}
	
	public function delete($id=0){
		$query = "DELETE FROM bibleWords WHERE id = " . $id;
		$this->db->query($query);		
		return True;		
	}
}

?>