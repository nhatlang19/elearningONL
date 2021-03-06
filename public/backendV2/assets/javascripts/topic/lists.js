// iosSwitcher
(function( $ ) {
	$('.showListStudentAnswer').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			type: 'post',
			dataType : "json",
			url : "get_list_for_download",
			data : {topic_manage_id: id},
			success : function(obj) {
			console.log(obj);
				if (!obj.status) {
					$('#modalHeaderColorPrimary').html(obj.data);
					$('.modal-basic').trigger('click');
				}
			},
			error : function(e) {
				/* handle the error code here */
				console.log(e);
			}
		});
	});
	
	$('.modal-basic').magnificPopup({
		type: 'inline',
		preloader: false,
		modal: true,
		callbacks: {
		    open: function() {
		    	var id = $('.modal-basic').attr('id');
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


}).apply(this, [ jQuery ]);

