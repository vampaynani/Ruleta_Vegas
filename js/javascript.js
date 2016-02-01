$(document).on('ready', function(){
	TweenLite.to('.container', 1, { display: "block", opacity: 1, onComplete: function(){
		TweenLite.to('form', 1, { display: "block", opacity: 1, ease: Power2.easeOut, y: 100});
	}});
	$('.send').on('click', function(e){
		e.preventDefault()
		TweenLite.to('form', 1, { display: "none", opacity: 0, ease: Power2.easeOut, y: 200, onComplete: function (){
			TweenLite.to('.ficha', 1, { display: "block", opacity: 1.5, ease: Power2.easeOut, y: 30, rotation: "-450deg"});
			TweenLite.to('.ruleta', 1, { display: "block", opacity: 1.5, ease: Power2.easeOut, y: 50, rotation: "-450deg", onComplete: function (){
				TweenLite.to('.flecha', .4, { display: "block", opacity: 1, ease: Power2.easeOut, y: 32});
				TweenLite.to('.jugar', .4, { display: "block", opacity: 1});
			}});
		}});
	});
	$('.jugar').on('click', function(e){
		e.preventDefault()
		TweenLite.to('.ruleta', 4, {rotation: "450deg", onComplete: function(){
			TweenLite.to('.premio', 1, { display: "block", opacity: 1, delay: "1",});
		}});
	});
});