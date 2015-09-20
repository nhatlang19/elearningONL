/*
Name: 			UI Elements / Modals - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

(function( $ ) {

	'use strict';

	/*
	Basic
	*/
	$('.modal-basic').magnificPopup({
		type: 'inline',
		preloader: false,
		modal: true
	});
	
	/*
	Modal Dismiss
	*/
	$(document).on('click', '.modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});

}).apply( this, [ jQuery ]);