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


}).apply(this, [ jQuery ]);

