$(document).on('ready', function(){
	TweenLite.to('.container', 1, { display: "block", opacity: 1, onComplete: function(){
		TweenLite.to('form', 1, { display: "block", opacity: 1, ease: Power2.easeOut, y: 100});
	}});
	$('.send').on('click', function(e){
		e.preventDefault();
		var formData = {
			method: 'save_user',
			nombre: $('#formName').val(),
			apellido: $('#formLastName').val(),
			mail: $('#formMail').val(),
			telefono: $('#formPhone').val()
		};
		$.post('json.php', formData, function(response){
			var tl = new TimelineLite();
			tl.to('form', 1, { display: "none", opacity: 0, ease: Power2.easeOut, y: 200});
			tl.to('.ficha', 1, { display: "block", opacity: 1.5, ease: Power2.easeOut, y: 30, rotation: "-450deg"});
			tl.to('.ruleta', 1, { display: "block", opacity: 1.5, ease: Power2.easeOut, y: 30, rotation: "-450deg"}, "-=1");
			tl.to('.flecha', .4, { display: "block", opacity: 1, ease: Power2.easeOut, y: 32});
			tl.to('.jugar', .4, { display: "block", opacity: 1});
			tl.to('.jugar', 1, {scale:1.3, repeat:-1, yoyo:true});
		});
	});
	$('.jugar').on('click', function(e){
		e.preventDefault();
		var formData = {
			method: 'play'
		};
		$.post('json.php', formData, function(response){
			console.log(response);
		});
		/*TweenMax.to('.jugar', .5, {scale:1, repeat:0, yoyo:false});
		TweenLite.to('.ruleta', 4, {rotation: "450deg", onComplete: function(){
			TweenLite.to('.premio', 1, { display: "block", opacity: 1, delay: "1",});
		}});*/
	});
});