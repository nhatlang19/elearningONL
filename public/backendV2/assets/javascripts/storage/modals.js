/*
Name: 			UI Elements / Modals - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

Dropzone.autoDiscover = false;

(function( $ ) {

	'use strict';

	/*
	Basic
	*/
	$('.modal-basic').magnificPopup({
		type: 'inline',
		preloader: false,
		modal: true,
		callbacks: {
		    open: function() {
		    	var id = $('.modal-basic').attr('id');
				$('.storage_id').val(id);
		    },
		  }
	});
	
	/*
	Modal Dismiss
	*/
	$(document).on('click', '.modal-confirm', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});
	
	var myDropzone = new Dropzone("#dropzone-example");
	  myDropzone.on("success", function(file, response) {
	    /* Maybe display some more file information on your page */
		  if(response.status) {
			  file.previewElement.classList.remove("dz-success");
	          return file.previewElement.classList.add("dz-error");
		  } else {
			  $.magnificPopup.close(); 
		  }
	  });
}).apply( this, [ jQuery ]);