<?php
include_once("models/PDODB.php");
class Item extends PDODB{
	public function __construct(){
		parent::__construct();
		$this->table = 'items';
	}
}