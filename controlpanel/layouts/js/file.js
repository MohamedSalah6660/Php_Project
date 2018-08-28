// there's a problem in this file , i dont know what is it ?


$(function (){
	'use strict'
// This Function About Placeholder in input 
// When you Focus Words Disappear , And the Opposite .

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

// Make Sure When You delete
$('.Confirm').click(function () {

	return confirm('Are You Sure?'); 


});



//Category View Option

// i think it's not working

$('.cat h3').click(function (){

	$(this).next('.full-view').fadeToggle(200);


});


// To Write under img
// it's not working until now

$('.live-name').keyup(function (){

	$('.live-preview .caption h3' ).text($(this).val());


});




// To  Hide and Show delete in Categories Page
// Doesnt work

$('.child-link').hover(function(){

	$($this).find('.show-delete').fadeIn(400);

},function(){


	$($this).find('.show-delete').fadeOut(400);
});




});