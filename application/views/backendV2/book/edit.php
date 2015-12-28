<div id="main-content">
	<!-- Main Content Section with everything -->


	<!-- Page Head -->


	<div class="clear"></div>
	<!-- End .clear -->

	<div class="content-box">
		<!-- Start Content Box -->

		<div class="content-box-header">

			<h3>
				<?php echo $title; ?>
			</h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->

		<div class="content-box-content">

			<div class="tab-content" id="tab1">

				<?php echo form_open(BACKEND_V2_TMPL_PATH . 'book/edit'); ?>

				<div class="notification error png_bg" style="display: none">
					<a href="#" class="close"> <img
						src="<?php echo BACKEND_V2_IMAGE_PATH; ?>cross_grey_small.png"
						title="Close this notification" alt="close" />
					</a>
					<div></div>
				</div>
				<fieldset>

					<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

					<div class="ui-widget">
						<label>Chọn đề thi</label> <select id="combobox"
							class="small-input">
							<option value="-1">Select one...</option>
							<?php foreach($topic_manage as $key => $value) : ?>
							<option value="<?php echo $value['topic_manage_id']; ?>">
								<?php echo trim(Commonobj::TrimAll($value['title'])); ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>


					<p>
						<input type="hidden" name="topic_manage_id" id="topic_manage_id"
							value="" /> <input class="button" id="submit" type="submit"
							value="Submit" /> <input class="button" type="button"
							value="Cancel" onclick="goback();" />
					</p>

				</fieldset>

				<div class="clear"></div>
				<!-- End .clear -->
				<input type='hidden' name='id' id='id'
					value='<?php if(isset($id)) echo $id; ?>' /> <input type='hidden'
					name='task' id='task' value='<?php if(isset($task)) echo $task; ?>' />
				<?php echo form_close(); ?>

			</div>
			<!-- End #tab2 -->
		</div>
		<!-- End .content-box-content -->

		<script>

		var lstTopic = new Array();
		
		<?php
$i = 1;
foreach ($topic_manage as $value) :
    ?>
			lstTopic[<?php echo $i++;?>] = <?php echo $value['topic_manage_id']; ?>;
		<?php endforeach;?>
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var input,
					that = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text().trim() : "",
					wrapper = this.wrapper = $( "<span>" )
						.addClass( "ui-combobox" )
						.insertAfter( select );

				function removeIfInvalid(element) {
					var value = $( element ).val(),
						matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
						valid = false;
					select.children( "option" ).each(function() {
						if ( $( this ).text().match( matcher ) ) {
							this.selected = valid = true;
							return false;
						}
					});
					if ( !valid ) {
						// remove invalid value, as it didn't match anything
						$( element )
							.val( "" )
							.attr( "title", value + " didn't match any item" )
							.tooltip( "open" );
						select.val( "" );
						setTimeout(function() {
							input.tooltip( "close" ).attr( "title", "" );
						}, 2500 );
						input.data( "autocomplete" ).term = "";
						return false;
					}
				}

				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value.trim() )
					.attr( "title", "" )
					.attr( "name", "topic_manage_value" )
					.addClass( "ui-state-default ui-combobox-input" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							// gan du lieu vao input hidden topic_manage_id 
							 var selectedObj = lstTopic[ui.item.option.index];
                            $('#topic_manage_id').val(selectedObj);
                            
							that._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							
							if ( !ui.item )
								return removeIfInvalid( this );
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.tooltip()
					.appendTo( wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-combobox-toggle" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							removeIfInvalid( input );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});

					input
						.tooltip({
							position: {
								of: this.button
							},
							tooltipClass: "ui-state-highlight"
						});
			},

			destroy: function() {
				this.wrapper.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
		$( "#combobox" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
	});
	</script>