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
		$today = date('Y-m-d', time()) . ' 00:00:00';
		$joins = array(
			array(
				"join" => "L",
				"table" => "items",
				"relation" => "users_items.id_item=items.id"
			)
		);
		$result = $this->_where_in_join($joins, "users_items.id", "nombre='$a' AND created_at>'$today'")->count();
		return $result;
	}
	public function total_traded( $a ){
		$item_id = $a->id;
		$count = $this->_where("id", "id_item=$item_id")->count();
		$available = $a->cantidad - $count;
		if($available <= 0) $available = 0; 
		return $available;
	}
	public function assign_to( $a, $b ){
		$data = array(
			'id_user' => $a,
			'id_item' => $b
		);
		return $this->_insert($data);
	}
	public function get_all_contestants(){
		$joins = array(
			array(
				"join" => "L",
				"table" => "users",
				"relation" => "users_items.id_user=users.id"
			),
			array(
				"join" => "L",
				"table" => "items",
				"relation" => "users_items.id_item=items.id"
			)
		);
		$result = $this->_where_in_join($joins, "users.nombre, users.apellido, users.correo, users.telefono, items.nombre AS item", "users_items.id IS NOT NULL")->get();
		return $result;
	}
}