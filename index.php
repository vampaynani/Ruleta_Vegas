<?php include ("_head.php") ?>
<body>
	<div class="container">
		<img src="./img/title.png">
		<div class="boxRuleta">
			<a href="" class="jugar">Play</a>
			<img src="./img/ficha.png" class="ficha">
			<img src="./img/flecha.png" class="flecha">
			<img src="./img/tablero.png" class="ruleta">
		</div>
		<form action="" id="form">
			<input type="text" name="name" placeholder="Nombre(s)" id="formName">
			<input type="text" name="lastName" placeholder="Apellido" id="formLastName">
			<input type="text" name="mail" placeholder="Correo" id="formMail">
			<input type="number" name="phone" placeholder="Teléfono" id="formPhone">
			<input type="submit" class="send">
		</form>
	</div>
	<div class="premio">
		<img src="./img/trofeo.gif">
		<p>texto de ganador</p>
		<a href="index.php">Play again</a>
	</div>
</body>
