<?php 
session_start();
include ("_head.php") 
?>
<body>
	<div class="container">
		<img src="./img/title.png" class="vegas">
		<div class="boxRuleta">
			<a href="" class="jugar">Play</a>
			<img src="./img/ficha.png" class="ficha">
			<img src="./img/flecha.png" class="flecha">
			<img src="./img/tablero.png" class="ruleta">
		</div>
		<form action="index.php" method="post" id="form">
			<p class="loading">Loading...</p>
			<p class="error"></p>
			<input type="text" name="name" placeholder="Nombre(s)" id="formName" required>
			<input type="text" name="lastName" placeholder="Apellido" id="formLastName" required>
			<input type="text" name="mail" placeholder="Correo" id="formMail" required>
			<input type="number" name="phone" placeholder="Teléfono" id="formPhone" required>
			<input type="submit" class="send" required>
		</form>
	</div>
	<div class="premio">
		<img src="./img/trofeo.gif">
		<p>Felicidades <span class="user_won"></span> ganaste <span class="item_won"></span></p>
		<!--a href="index.php">Play again</a-->
	</div>
	<!--audio src="./img/vegas.mp3" autoplay></audio-->
</body>
