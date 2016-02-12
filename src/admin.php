<?php 
session_start();
include_once ("_head.php");
include_once ("models/user_item.php");
/*
 * Admin Credentials
 * Usr: AdminSOC // Pwd: V3g4$3$0r3s
 * @echo password_hash('AdminSOC', PASSWORD_DEFAULT)."\n";
 * @echo password_hash('V3g4$3$0r3s', PASSWORD_DEFAULT)."\n";
 */
if(isset($_POST['method'])){
	switch($_POST['method']){
		case 'login':
			if(password_verify($_POST['usr'], '$2y$10$bnRkL8y4UuJU8uRSJ0lMpuFJpeaVzLnhQbdCfUzVUnqufWTipqo7a') 
				&& password_verify($_POST['pwd'], '$2y$10$3EpeVSvtNswi7W4ArW8QVuniRBb4IQ4GFP/8QUjyO6lFFKtBEZfim') ){
				$_SESSION['admin'] = base64_encode($_POST['usr'] . $_POST['pwd']);
			}
			break;
	}
}
?>
<body>
	<div class="admin container">
		<?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == base64_encode("AdminSOCV3g4$3$0r3s")): 
			$ui = new UserItem();
			$contestants = $ui->get_all_contestants();
		?>
		<table>
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Correo</th>
					<th>Teléfono</th>
					<th>Premio</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($contestants as $user): ?>
				<tr>
					<td><?php echo $user->nombre ?></td>
					<td><?php echo $user->apellido ?></td>
					<td><?php echo $user->correo ?></td>
					<td><?php echo $user->telefono ?></td>
					<td><?php echo $user->item ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<?php else: ?>
		<form method="post" id="admin_form">
			<p class="error"></p>
			<input type="text" name="usr" placeholder="Usuario" id="formMail" required>
			<input type="password" name="pwd" placeholder="Password" id="formPhone" required>
			<input type="hidden" name="method" value="login">
			<input type="submit" required>
		</form>
		<?php endif; ?>
	</div>
</body>