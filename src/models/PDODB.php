<?php
include_once("config/core.php");
include_once("models/PDOResult.php");

class PDODB{
	private $DBH;
	protected $table;
	protected function __construct(){
		try{
			$this->DBH = new PDO("mysql:host=".DB_SRVR.";dbname=".DB_NAME, DB_USR, DB_PWD);
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	protected function _relationship( $q ){
		$STH = $this->DBH->exec( $q );
	}
	protected function _query( $q ){
		$result = array();
		$STH = $this->DBH->query( $q );
		$STH->setFetchMode(PDO::FETCH_OBJ);
		while( $row = $STH->fetch() ){
			$result[] = $row;
		}
		return new PDOResult( $result );
	}
	protected function _insert( $data ){
		$fields = array();
		foreach($data as $key=>$value){
			$fields[] = $key;
		}
		$fieldsstr = implode( ', ', $fields );
		$fieldsval = ':' . implode( ', :', $fields );
		$STH = $this->DBH->prepare("INSERT INTO " . $this->table . " ( $fieldsstr, created_at ) value ( $fieldsval, NOW() )");
		$STH->execute( $data );
		return $this->DBH->lastInsertId();
	}
	protected function _all( $fields ){
		$result = array();
		$STH = $this->DBH->query("SELECT $fields FROM " . $this->table);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		while( $row = $STH->fetch() ){
			$result[] = $row;
		}
		return new PDOResult( $result );
	}
	protected function _where( $fields, $condition ){
		$result = array();
		$STH = $this->DBH->query("SELECT $fields FROM " . $this->table . " WHERE $condition");
		//echo "SELECT $fields FROM " . $this->table . " WHERE $condition";
		if($STH){
			$STH->setFetchMode(PDO::FETCH_OBJ);
			while( $row = $STH->fetch() ){
				$result[] = $row;
			}
			return new PDOResult( $result );
		}else{
			return new PDOResult( NULL );
		}
	}
	protected function _where_in_join( $joins, $fields, $condition ){
		$result = array();
		$query = "SELECT $fields FROM " . $this->table;
		foreach ($joins as $join) {
			switch($join['join']){
				case 'L':
					$query .= " LEFT JOIN ";
					break;
				case 'R':
					$query .= " RIGHT JOIN ";
					break;
			}
			$query .= $join['table'] . " ON ";
			$query .= $join['relation'];
		}
		$query .= " WHERE $condition";
		//echo $query."<br /><br />";
		$STH = $this->DBH->query($query);
		if($STH){
			$STH->setFetchMode(PDO::FETCH_OBJ);
			while( $row = $STH->fetch() ){
				$result[] = $row;
			}
			return new PDOResult( $result );
		}else{
			return new PDOResult( NULL );
		}
	}
	protected function _delete( $condition ){
		$this->DBH->exec("DELETE FROM " . $this->table . " WHERE $condition");
		return true;  
	}
	protected function _update( $data, $condition ){
		$fields = array();
		foreach($data as $key=>$value){
			$fields[] = $key . '=:' . $key;
		}
		$fieldsstr = implode( ', ', $fields );
		$STH = $this->DBH->prepare("UPDATE " . $this->table . " SET $fieldsstr WHERE $condition");
		$STH->execute( $data );
		return $STH->rowCount();	
	}
}