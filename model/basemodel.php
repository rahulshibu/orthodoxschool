<?php

if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once('dbmanager/pdodb.class.php');

class BaseModel {
	protected $db         = null;
	protected $table_name = "";
	
	public function __construct(){
		$this->db = new DB();
	}
	
	protected function insert($obj){
		$query = "INSERT INTO " . $this->table_name . " (%s) VALUES (%s);";
		$data  = $this->getTableColsAndValues($obj);	
		$query = sprintf($query, $data->cols, $data->values);	
		
		$this->db->query($query);
		$response  = $this->db->query("SELECT LAST_INSERT_ID()");		
		$obj["id"] = $response[0]["LAST_INSERT_ID()"];
		return $obj;
	}
	
	protected function update($obj, $where = []){
		$cols        = "";
		$whereClause = NULL;
		if(count($where) == 0){
			$whereClause = "";
		} else {
			$whereClause = " WHERE ";
		}
		
		$query = "UPDATE " . $this->table_name . " SET %s %s;";
		
		// Cols
		foreach ($obj as $key => $val) {
			$values = "";
			if($key != "id"){
				$val = str_replace("'",'"',$val);
				if(is_numeric($val)){
						$values = $val;
				} else if(is_bool($val)){					
					$bool_val = ($val) ? 1 : 0;					
					$values = $val;
				} else {
					$values = "'" . $val . "'";
				}
				$cols .= $key . '='. $values . ',';
			}
		}
		
		// Where condition
		foreach ($where as $key => $val) {
			$values = "";
			$val = str_replace("'",'"',$val);
			if(is_numeric($val)){
					$values = $val;
			} else if(is_bool($val)){					
				$bool_val = ($val) ? 1 : 0;					
				$values = $val;
			} else {
				$values = "'" . $val . "'";
			}
			$whereClause .= $key . '='. $values . ' AND';
		}
		
		$cols        = rtrim($cols,",");
		$whereClause = rtrim($whereClause," AND");		
		$query       = sprintf($query, $cols, $whereClause);	
				
		$this->db->query($query);
		return $obj;
	}
	
	private function getTableColsAndValues($obj){		
		$cols   = "";
		$values = "";
		
		foreach ($obj as $key => $val) {
			if($key != "id"){
				$val = str_replace("'",'"',$val);
				$cols .= $key . ",";				
				if(is_numeric($val)){
					$values .= $val . ",";
				} else if(is_bool($val)){					
					$bool_val = ($val) ? 1 : 0;					
					$values .= $val . ",";
				} else {
					$values .= "'" . $val . "',";
				}
			}
		}
		
		$return_Value         = new stdClass;
		$return_Value->cols   = rtrim($cols,",");
		$return_Value->values = rtrim($values,",");
		return  $return_Value;
	}
}

?>