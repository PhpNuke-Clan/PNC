// Functions
jQuery(function($) {

	// fading postbit, pagination and sumbmit buttons
	$('img[src*=themes/BF3/forums/images/lang_english/], img[src*=themes/BF3/images/menu/], .button, .mainoption, .liteoption, .btn-4, .submit, .catbutton, .avatar, #spotlight')
	.hover(function() {
		$(this).animate({
			opacity: .7
		});
	}, function() {
		$(this).animate({
			opacity: 1
		});
	});

});
