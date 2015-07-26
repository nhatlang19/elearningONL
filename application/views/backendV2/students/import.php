<div id="main-content">
	<!-- Main Content Section with everything -->


	<!-- Page Head -->


	<div class="clear"></div>
	<!-- End .clear -->

	<div class="content-box">
		<!-- Start Content Box -->

		<div class="content-box-header">

			<h3><?php echo $title; ?></h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->

		<div class="content-box-content">

			<div class="tab-content" id="tab1">

				<?php echo form_open_multipart(BACKEND_V2_TMPL_PATH . 'students/import'); ?>

					<div class="notification error png_bg" style="display: none">
					<a href="#" class="close"> <img
						src="<?php echo BACKEND_V2_IMAGE_PATH; ?>cross_grey_small.png"
						title="Close this notification" alt="close" /></a>
					<div></div>
				</div>
				<fieldset>


					<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
					<p>
						<label>Chọn file: (Download template from <a
							href="<?php echo BACKEND_V2_TEMPLATES_PATH; ?>template_student_lists.xls">here</a>)
						</label> <input type="file" name="uploadfile" id="uploadfile" />
					</p>


					<p>
						<label>Lớp</label> <select name="class_id" id="class_id"
							class="small-input">
							<option value="-1">Chọn lớp</option>
								<?php foreach($classes as $class) : ?>
									<option value="<?php echo $class['class_id']; ?>"><?php echo $class['class_name']; ?></option>
								<?php endforeach; ?>
							</select>
					</p>

					<p>
						<input class="button" id="submit" type="submit" value="Submit" />

						<input class="button" type="button" value="Cancel"
							onclick="goback();" />
					</p>

				</fieldset>

				<div class="clear"></div>
				<!-- End .clear -->
				<?php echo form_close(); ?>	

			</div>
			<!-- End #tab2 -->
		</div>
		<!-- End .content-box-content -->
		<script type="text/javascript">
var ERROR = '';
			<?php if($error) :?>
			ERROR = '<?php echo $error; ?>';
			<?php endif; ?>
		</script>
		<script src="<?php echo BACKEND_V2_JS_PATH; ?>students/import.js"></script>