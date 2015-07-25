$(function() {
	// this bit needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            csrf_test_name: $.cookie('csrf_cookie_name')
        }
    });
	
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