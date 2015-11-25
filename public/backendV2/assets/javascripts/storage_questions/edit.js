/*
Name: 			UI Elements / Modals - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

(function( $ ) {

	'use strict';

	$( "form" ).submit(function( event ) {
		event.preventDefault();
		var $form = $(this);
		var formData = $(this).serializeArray();

		var object = {name:"question_name", value:$('.question_name').code()}; 
		formData.push(object);

		$.each( $('.answer_name'), function( key, value ) {
			var object = {name:"answer_name[]", value: $(value).code()}; 
			formData.push(object);
		});
		$.ajax({
	        url: $form.attr('action'),
	        data: formData,
	        dataType: "json",
	        type: 'POST',
	        success: function(result) {
	            if(!result.status) {
	         	   location.href = 'lists.html';
	            } else {
	                $('.alert-danger div').html(result.message);
	                $('.alert-danger').removeClass('hide');
	                $('body').scrollTop(0);
	            }
	        }
	    });
	});

}).apply( this, [ jQuery ]);