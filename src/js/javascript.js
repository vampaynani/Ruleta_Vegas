$(document).on('ready', function(){
	createjs.Sound.registerSound("./sounds/ruleta.mp3", "ruleta");

	var tl = new TimelineLite();
	tl.to('.container', 1, { display: "block", opacity: 1});
	tl.to('form', 1, { display: "block", opacity: 1, ease: Power2.easeOut, y: 100});
	
	$('.send').on('click', function(e){
		e.preventDefault();
		var formData = {
			method: 'save_user',
			nombre: $('#formName').val(),
			apellido: $('#formLastName').val(),
			mail: $('#formMail').val(),
			telefono: $('#formPhone').val()
		};
		$('.loading').show();
		$.post('json.php', formData, function(response){
			$('.loading').hide();
			if(response.code == 200){
				var tl = new TimelineLite();
				TweenLite.set('.ficha', {display: "block"});
				TweenLite.set('.ruleta', {display: "block"});
				TweenLite.set('.flecha', {display: "block"});
				tl.to('form', 1, { display: "none", opacity: 0, ease: Power2.easeOut, y: 200});
				tl.from('.ficha', 1, { opacity: 0, ease: Power2.easeOut, y: -30, rotation: "-450deg"});
				tl.from('.ruleta', 1, { opacity: 0, ease: Power2.easeOut, y: -30, rotation: "-450deg"}, "-=1");
				tl.from('.flecha', .4, { opacity: 0, ease: Power2.easeOut, y: -30});
				tl.to('.jugar', .4, { display: "block", opacity: 1});
				tl.to('.jugar', 1, {scale:1.3, repeat:-1, yoyo:true});
			}else{
				$('.error').text(response.error);
			}
		});
	});
	$('.jugar').on('click', function(e){
		e.preventDefault();
		$('.jugar').off('click');

		TweenLite.to('.jugar', 0.4, {scale: 1});
		TweenMax.to('.ruleta', 1, {rotation: 360, ease: Linear.easeNone, repeat: -1});
		
		createjs.Sound.play("ruleta");

		var formData = { method: 'play' };
		
		$.post('json.php', formData, function(response){
			var box = 0;
			var pre = '';
			TweenMax.killAll();
			createjs.Sound.stop();
			if(response.code == 500){
				alert(response.error);
			}else{
				switch(parseInt(response.data.id)){
					case 2:
					case 6:
						pre = 'una';
						break;
					case 3:
						pre = 'un';
						break;
					case 4:
					case 7:
						pre = 'unos';
						break; 
				}
				$('.item_won').text(pre+' '+response.data.nombre);
				$('.user_won').text(response.data.user);
				switch(parseInt(response.data.id)){
					case 2:
						box = 14;
						break;
					case 3:
						box = 16;
						break;
					case 4:
						box = 13;
						break;
					case 6:
						box = 12;
						break;
					case 7:
						box = 15;
						break;
				}

				var tl = new TimelineLite();
				tl.to('.ruleta', 1, {rotation: 360 + box * 22.5});
				tl.to('.premio', 1, {display: "block", opacity: 1, delay: 1});
			}
		});
	});
});