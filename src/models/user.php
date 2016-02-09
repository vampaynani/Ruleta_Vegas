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
		$data = $this->_where("id", "correo='$a'")->get()[0]->id;
		return $data;
	}
	public function get_by_token( $t ){
		$result = $this->_where("photo_name, emotion", "request_token='$t'")->get();
		return $result;
	}
	public function get_posts_pages(){
		$count = $this->_where("id", "email != ''")->count();
		return floor( $count / $this->by_page );
	}
	public function get_posts( $page = 0 ){
		$init = $page * $this->by_page;
		$by_page = $this->by_page;
		$result = $this->_where("email, photo_name, emotion", "email != '' ORDER BY id DESC LIMIT $init, $by_page")->get();
		return $result;
	}
	public function get_posts_private( $page = 0 ){
		$init = $page * $this->by_page;
		$by_page = $this->by_page;
		$result = $this->_where("request_token AS _key, emotion", "email != '' ORDER BY id DESC LIMIT $init, $by_page")->get();
		return $result;
	}
}