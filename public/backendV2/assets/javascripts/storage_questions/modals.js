/*
Name: 			UI Elements / Modals - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

(function( $ ) {

	'use strict';

	/*
	Modal Confirm
	*/
	$(document).on('click', '.modal-confirm', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});


	/*
	Ajax
	*/
	$('.sq-ajax-modal').magnificPopup({
		type: 'ajax',
		modal: true
	});

}).apply( this, [ jQuery ]);