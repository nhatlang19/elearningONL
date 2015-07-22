$(document).ready(function() {
	// delete click
	$('.btdelete').click(function(e) {
		if(!confirm('Bạn có chắc chắn xóa không?')) {
			e.preventDefault();
		}
	})
	
	$('.number_inp').keypress(function(e) {		
		if( e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
			e.preventDefault();
	});
});