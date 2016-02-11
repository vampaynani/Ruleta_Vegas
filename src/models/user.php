<?php
include_once("models/PDODB.php");
class User extends PDODB{
	private $by_page;
	public function __construct(){
		parent::__construct();
		$this->table = 'users';
	}
	public function create( $a, $b, $c, $d ){
		$data = array( "nombre" => $a, "apellido" => $b, "correo" => $c, "telefono" => $d );
		$result = $this->_insert( $data );
		return $result;
	}
	public function exist( $a ){
		$data = $this->_where("id", "correo='$a'")->get();
		if($data) $data = $data[0]->id;
		return $data;
	}
	public function get_name( $a ){
		$data = $this->_where("nombre, apellido", "id=$a")->get();
		return $data[0]->nombre . ' ' . $data[0]->apellido;
	}
}