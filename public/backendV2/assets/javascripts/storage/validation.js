(function() {

	'use strict';
	var rules = {
	  'title': {
	    required: true,
	    maxlength: '255',
	    minlength: '6'
	  }
	};

	// basic
	$("#form").validate({
		rules:rules, 
		highlight: function( label ) {
			$(label).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function( label ) {
			$(label).closest('.form-group').removeClass('has-error');
			label.remove();
		},
		errorPlacement: function( error, element ) {
			var placement = element.closest('.input-group');
			if (!placement.get(0)) {
				placement = element;
			}
			if (error.text() !== '') {
				placement.after(error);
			}
		}
	});
}).apply( this, [ jQuery ]);