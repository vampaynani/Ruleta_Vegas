<?php
class PDODBTest extends PHPUnit_Framework_TestCase{
	public function testEmptyResult(){
		$a = new PDOResult(array());
		$b = $a->get();
		$this->assertEmpty($b);
	}
}