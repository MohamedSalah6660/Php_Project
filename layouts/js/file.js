$(function (){
	'use strict'
	$('[placeholder]').focus(function () {

		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '' );

	}).blur(function(){
		$(this).attr('placeholder', $(this).attr('data-text'));



	});


// Add *  on Required field

$('input').each(function () {

	if ($(this).attr('required') === 'required') {

		$(this).after('<span class="asterisk">*</span>');


	}


});

//////////////////////////////////////


$('.login-page h1 span').click(function(){

	$(this).addClass('selected').siblings().removeClass('selected');

	$('.login-page form').hide();

	$( '.' +$(this).data('class')).fadeIn(100);

});


});