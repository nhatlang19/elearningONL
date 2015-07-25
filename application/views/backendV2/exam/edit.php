
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

				<?php echo form_open(BACK_END_TMPL_PATH . 'exam/edit'); ?>

					<div class="notification error png_bg" style="display: none">
					<a href="#" class="close"> <img
						src="<?php echo BACK_END_IMAGE_PATH; ?>cross_grey_small.png"
						title="Close this notification" alt="close" /></a>
					<div></div>
				</div>
				<fieldset>


					<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

					<p>
						<label>Hình thức thi</label> <input
							class="text-input medium-input answer_name" type="text"
							name="title" id="title"
							value="<?php if(isset($exam['title'])) echo $exam['title']; ?>" />
					</p>

					<p>
						<label>Thời gian ( phút )</label> <input
							class="text-input medium-input answer_name" type="text"
							name="time" id="time"
							value="<?php if(isset($exam['time'])) echo $exam['time']; ?>" />
					</p>


					<p>
						<input class="button" id="submit" type="submit" value="Submit" />

						<input class="button" type="button" value="Cancel"
							onclick="goback();" />
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

		<!-- </div>  End .content-box -->
		<script src="<?php echo BACK_END_JS_PATH; ?>exam/edit.js"></script>