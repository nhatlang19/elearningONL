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
		    	if(id != $('.storage_id').val()) {
		    		$('#dropzone-example').find('.dz-preview').remove();
		    	}
				$('.storage_id').val(id);
		    },
		  }
	});
	
	/*
	Modal Dismiss
	*/
	$(document).on('click', '.modal-confirm', function (e) {
		e.preventDefault();
		$('#dropzone-example').find('.dz-preview').remove();
		$('#dropzone-example').find('.dz-message').css('opacity', 1);
		$.magnificPopup.close();
	});
	
	var myDropzone = new Dropzone("#dropzone-example");
	  myDropzone.on("success", function(file, response) {
	    /* Maybe display some more file information on your page */
		  $('#dropzone-example input[name="csrf_lph_token"]').val(response.data.csrf.hash);
		  
		  if(response.status) {
			  $(file.previewElement).find('.dz-error-message').text(response.message);
			  file.previewElement.classList.remove("dz-success");
	          return file.previewElement.classList.add("dz-error");
		  } else {
			  $('#tr' + $('.storage_id').val()).find('td.num-question').html(response.data.numberOfQuestions);
			  
			  $('#dropzone-example').find('.dz-preview').remove();
			  $('#dropzone-example').find('.dz-message').css('opacity', 1);
			  $.magnificPopup.close(); 
		  }
	  });
}).apply( this, [ jQuery ]);