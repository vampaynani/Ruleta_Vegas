<?php
include_once("models/PDODB.php");
class UserItem extends PDODB{
	public function __construct(){
		parent::__construct();
		$this->table = 'users_items';
	}
	public function num_of_participations( $a ){
		return $this->_where("id", "id_user='$a'")->count();
	}
	public function get_available_today( $a ){
		date_default_timezone_set('America/Mexico_City');
		$today = date('Y-m-d', time()) . ' 00:00:00';
		$joins = array(
			array(
				"join" => "L",
				"table" => "items",
				"relation" => "users_items.id_item=items.id"
			)
		);
		$result = $this->_where_in_join($joins, "id", "nombre='$a' AND created_at>'$today'")->count();
		return $result;
	}
}