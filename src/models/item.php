<?php
include_once("models/PDODB.php");
class Item extends PDODB{
	public function __construct(){
		parent::__construct();
		$this->table = 'items';
	}
	public function get_total($item){
		$result = $this->_where("id, cantidad", "nombre='$item'")->get()[0];
		return $result;
	}
	public function get_data( $a ){
		$result = $this->_where("id, nombre", "id='$a'")->get()[0];
		return $result;
	}
}