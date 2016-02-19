<?php
	session_start();
	date_default_timezone_set('America/Mexico_City');

	include_once("models/user.php");
	include_once("models/item.php");
	include_once("models/user_item.php");
	
	if( empty($_POST) ) header("HTTP/1.1 500 Internal Server Error");
	
	header('Content-Type: application/json');
	
	$user = new User();
	$item = new Item();
	$ui = new UserItem();
	$max_participations = 1;

	switch(@$_POST['method']){
		case 'save_user':
			$name = $_POST['nombre'];
			$lastname = $_POST['apellido'];
			$mail = $_POST['mail'];
			$phone = $_POST['telefono'];

			evaluate($name, 'nombre');
			evaluate($lastname, 'apellido');
			evaluate($mail, 'correo', 'isEmail');
			evaluate($phone, 'teléfono', 'isPhone');

			$id = $user->exist($mail);
			if(!$id) $id = $user->create($name, $lastname, $mail, $phone);
			if( $ui->num_of_participations($id) >= $max_participations) fail("Has llegado al límite de participaciones por usuario, gracias por tu interés");
			
			$_SESSION['id'] = base64_encode($id);
			response($id);
			break;
		case 'play':
			$id = base64_decode($_SESSION['id']);
			if( $ui->num_of_participations($id) >= $max_participations ) fail("Has llegado al límite de participaciones por usuario, gracias por tu interés");
			$mochilas = 1;
			$audifonos = 0;
			/*$t_mochilas = $ui->total_traded( $item->get_total('mochila') );
			$t_audifonos = $ui->total_traded( $item->get_total('audifonos') );
			
			if( $t_mochilas > 0 ){
				$mochilas -= $ui->get_available_today( 'mochila' );
			}else{
				$mochilas = 0;	
			} 
			if( $t_audifonos > 0 ) {
				$audifonos -= $ui->get_available_today( 'audifonos' );
			}else{
				$audifonos = 0;
			}*/
			$mochilas -= $ui->get_available_today( 'mochila' );
			$audifonos -= $ui->get_available_today( 'audifonos' );

			$items = array(2,2,2,3,3,3,4,4);

			if($mochilas > 0){
				array_push($items, 6);
				array_push($items, 6);
			}
			if($audifonos > 0) array_push($items, 7);

			shuffle($items);

			$selected = rand(0, count($items) - 1);
			$iselected = $items[$selected];
			$ui->assign_to($id, $iselected);
			$data = $item->get_data($iselected);
			$data->user = $user->get_name($id);
			response($data);
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
	function evaluate($value, $key, $rules=null){
		$error = "Debes escribir un $key válido";
		if(!$value || $value == '') fail($error);
		$rules_list = explode('|', $rules);
		foreach ($rules_list as $rule) {
			switch($rule){
				case 'isEmail':
					if( !filter_var($value, FILTER_VALIDATE_EMAIL) ) fail('Debes escribir un correo válido');
					break;
				case 'isPhone':
					if(count(str_split($value)) < 7 || count(str_split($value)) > 10 || !filter_var($value, FILTER_VALIDATE_INT) ) fail('Debes escribir un teléfono válido');
					break;
			}
		}
	}
	