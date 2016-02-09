<?php
class Validator{
	
	public static $errors;
	public static $valid = true;
	
	public static function validate( $fields ){
		foreach($fields as  $field ){
			$rules = explode( ",", $field['rules'] );
			$value = $field['value'];
			$name = $field['name'];
			foreach( $rules as $rule ){
				self::$rule( $name, $value );
			}
		}
	}
	
	private static function required( $name, $value ){
		if( !isset($value) || empty( $value ) ){
			self::$valid = false;
			self::$errors[] = "el campo " . $name . " es requerido";
		}
	}
	
	private function file( $name, $value ){
		if( !isset($value) || empty( $value ) ){
			self::$valid = false;
			self::$errors[] = "el campo " . $name . " es requerido";
		}
		if ($value['error'] > 0){
  			self::$errors[] = $value['error'];
  		}
	}

	private static function selection( $name, $value ){
		if( $value=="-1" ){
			self::$valid = false;
			self::$errors[] = "no has seleccionado un valor para " . $name;
		}
	}
	
	private static function email( $name, $value ){
		$mail_rule = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
		if( !preg_match( $mail_rule, $value ) ){
			self::$valid = false;
			self::$errors[] = "el campo " . $name . " no está bien escrito";
		}
	}
	
	private static function phone( $name, $value ){
		$phone_rule = "/^[0-9]{10}$/";
		if( !preg_match( $phone_rule, $value ) ){
			self::$valid = false;
			self::$errors[] = "el campo " . $name . " tiene caracteres inválidos";
		}
	}
}