(function() {

	'use strict';
	var rules = {
	  'indentity_number': {
	    required: true,
	    maxlength: '255',
	    minlength: '1'
	  },
	  'fullname': {
		    required: true,
		    maxlength: '255',
		    minlength: '8'
		  }
	};

	// basic
	$("#form").validate({
		rules:rules, 
		highlight: function( label ) {
			console.log(label);
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