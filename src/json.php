<?php
	session_start();

	include_once("models/user.php");
	include_once("models/item.php");
	include_once("models/user_item.php");
	
	if( empty($_POST) ) header("HTTP/1.1 500 Internal Server Error");
	
	header('Content-Type: application/json');
	
	$user = new User();
	$item = new Item();
	$ui = new UserItem();
	$max_participations = 1;

	switch($_POST['method']){
		case 'save_user':
			$name = $_POST['nombre'];
			$lastname = $_POST['apellido'];
			$mail = $_POST['mail'];
			$phone = $_POST['telefono'];

			evaluate($name, 'nombre');
			evaluate($lastname, 'apellido');
			evaluate($mail, 'correo');
			evaluate($phone, 'teléfono');

			$id = $user->exist($mail);
			if(!$id) $id = $user->create($name, $lastname, $mail, $phone);
			if( $ui->num_of_participations($id) >= $max_participations) fail("Has llegado al límite de participaciones por usuario, gracias por tu interés");
			
			$_SESSION['id'] = base64_encode($id);
			response($id);
			break;
		case 'play':
			$mochilas = 2;
			$audifonos = 1;
			$id = base64_decode($_SESSION['id']);
			
			$t_mochilas = $ui->get_available_today('mochilas');
			$t_audifonos = $ui->get_available_today('audifonos');
			
			echo($mochilas - $t_mochilas);
			echo($audifonos - $t_audifonos);

			break;
	};

	function response($data){
		$result = array('code' => 200, 'data' => $data, 'error' => null);
		echo json_encode($result);
		exit;
	}
	function fail($error){
		$result = array('code' => 500, 'data' => null, 'error' => $error);
		echo json_encode($result);
		exit;
	}
	function evaluate($value, $key){
		$error = "Debes escribir un $key válido";
		if(!$value || $value == '') fail($error);
	}
	