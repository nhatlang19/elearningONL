// iosSwitcher
(function( $ ) {

	'use strict';
	
	if ( typeof Switch !== 'undefined' && $.isFunction( Switch ) ) {

		$(function() {
			$('[data-plugin-ios-switch-preview]').each(function() {
				var $this = $( this );
				
				$this.themePluginIOS7Switch(function() {
					var id = $this.data('id');
					var change_to = $this.data('review');
					$.ajax({
						type: 'post',
						dataType : "json",
						url : "change_review",
						data : {topic_manage_id: id, change_to: change_to},
						success : function(obj) {
							if (obj.status) {
								$this.data('review', obj.changeTo);
							} else {
								alert(obj.message);
							}
						},
						error : function(e) {
							/* handle the error code here */
							console.log(e);
						}
					});
				});
			});
			
			
		});

	}
	
	$('.showListStudentAnswer').click(function() {
		var id = $(this).attr('id');
		$.ajax({
			type: 'post',
			dataType : "json",
			url : "get_list_for_download",
			data : {topic_manage_id: id},
			success : function(obj) {
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

