/*
Name: 			Tables / Editable - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

(function( $ ) {

	'use strict';

	var EditableTable = {

		options: {
			addButton: '#addToTable',
			table: '#datatable-editable',
			dialog: {
				wrapper: '#dialog',
				cancelButton: '#dialogCancel',
				confirmButton: '#dialogConfirm',
			},
			dialogFailed: {
				wrapper: '#dialogFailed',
				confirmButton: '#dialogFailedAccecpted',
			}
		},

		initialize: function() {
			this
				.setVars()
				.build()
				.events();
		},

		setVars: function() {
			this.$table				= $( this.options.table );
			this.$addButton			= $( this.options.addButton );

			// dialog
			this.dialog				= {};
			this.dialog.$wrapper	= $( this.options.dialog.wrapper );
			this.dialog.$cancel		= $( this.options.dialog.cancelButton );
			this.dialog.$confirm	= $( this.options.dialog.confirmButton );
			
			this.dialogFailed			= {};
			this.dialogFailed.$wrapper	= $( this.options.dialogFailed.wrapper );
			this.dialogFailed.$confirm	= $( this.options.dialogFailed.confirmButton );

			return this;
		},

		build: function() {
			var _self = this;
			this.datatable = this.$table.DataTable({
				aoColumns: [
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					{ "bSortable": false }
				],
				"fnDrawCallback": function( oSettings ) {
					if ( typeof Switch !== 'undefined' && $.isFunction( Switch ) ) {
						_self.$table.find('[data-plugin-ios-switch]').each(function() {
							var $this = $( this );
							$this.themePluginIOS7Switch(function() {
								var id = $this.data('id');
								var status = $this.data('status');
								$.ajax({
									type: 'post',
									dataType : "json",
									url : "change_status",
									data : {id: id, status: status},
									success : function(obj) {
										if (obj.status) {
											$this.data('status', obj.data.changeStatus);
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
					}
				}
			});

			window.dt = this.datatable;

			return this;
		},

		events: function() {
			var _self = this;

			this.$table
				.on('click', 'a.edit-row', function( e ) {
					e.preventDefault();

					_self.rowEdit( $(this).closest( 'tr' ) );
				})
				.on( 'click', 'a.remove-row', function( e ) {
					e.preventDefault();

					var $row = $(this).closest( 'tr' );

					$.magnificPopup.open({
						items: {
							src: '#dialog',
							type: 'inline'
						},
						preloader: false,
						modal: true,
						callbacks: {
							change: function() {
								_self.dialog.$confirm.on( 'click', function( e ) {
									e.preventDefault();

									_self.rowRemove( $row );
									$.magnificPopup.close();
								});
							},
							close: function() {
								_self.dialog.$confirm.off( 'click' );
							}
						}
					});
				});

			this.$addButton.on( 'click', function(e) {
				e.preventDefault();

				_self.rowAdd();
			});

			this.dialog.$cancel.on( 'click', function( e ) {
				e.preventDefault();
				$.magnificPopup.close();
			});

			return this;
		},

		// ==========================================================================================
		// ROW FUNCTIONS
		// ==========================================================================================
		rowAdd: function() {
			this.$addButton.attr({ 'disabled': 'disabled' });
			
			location.href = 'edit.html';
		},

		rowEdit: function( $row ) {
			location.href = 'edit/' + $row.data('id') + '.html';
		},

		rowRemove: function( $row ) {
			var _self = this;
			
			if ( $row.hasClass('adding') ) {
				this.$addButton.removeAttr( 'disabled' );
			}
			var tmpDataTable = this.datatable;
			$.ajax({
				url : "delete/" + $row.data('id'),
				success : function(response) {
					if(!response.status) {
						tmpDataTable.row( $row.get(0) ).remove().draw();
					} else {
						$('.modal-text p').text(response.message);
						$.magnificPopup.open({
							items: {
								src: '#dialogFailed',
								type: 'inline'
							},
							preloader: false,
							modal: true,
							callbacks: {
								change: function() {
									_self.dialogFailed.$confirm.on( 'click', function( e ) {
										e.preventDefault();
										$.magnificPopup.close();
									});
								},
								close: function() {
									_self.dialogFailed.$confirm.off( 'click' );
								}
							}
						});
					}
				},
			});
		},
	};

	$(function() {
		EditableTable.initialize();
	});

}).apply( this, [ jQuery ]);