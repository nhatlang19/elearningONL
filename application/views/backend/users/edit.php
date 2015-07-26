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

				<?php echo form_open_multipart(BACKEND_V2_TMPL_PATH . 'users/edit', array('autocomplete' => 'off')); ?>

					<div class="notification error png_bg" style="display: none">
					<a href="#" class="close"> <img
						src="<?php echo BACKEND_V2_IMAGE_PATH; ?>cross_grey_small.png"
						title="Close this notification" alt="close" /></a>
					<div></div>
				</div>
				<fieldset>


					<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

					<p>
						<label>Tên đăng nhập</label> <input
							class="text-input medium-input answer_name" type="text"
							name="username" id="username"
							value="<?php echo @$user['username']; ?>" />
					</p>
					<p>
						<label>Mật khẩu</label> <input
							class="text-input medium-input answer_name" type="password"
							name="password" id="password" value="" />
					</p>
					<p>
						<label>Email</label> <input
							class="text-input medium-input answer_name" type="text"
							name="email" id="email" value="<?php echo @$user['email']; ?>" />
					</p>
					<p>
						<label>Chọn môn dạy</label> <select id="combobox"
							name="subjects_id" class="small-input">
							<option value="-1">Select one...</option>
							<?php
    
foreach ($subjects as $key => $value) :
        $selected = '';
        if ($value['subjects_id'] == $user['subjects_id'])
            $selected = 'selected="selected"';
        ?>
							<option value="<?php echo $value['subjects_id']; ?>"
								<?php echo $selected; ?>>
								<?php echo $value['subjects_name']; ?>
							</option>
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
				<input type='hidden' name='id' id='id'
					value='<?php if(isset($id)) echo $id; ?>' /> <input type='hidden'
					name='task' id='task' value='<?php if(isset($task)) echo $task; ?>' />
				<?php echo form_close(); ?>	

			</div>
			<!-- End #tab2 -->
		</div>
		<!-- End .content-box-content -->

		<!-- </div>  End .content-box -->
		<script src="<?php echo BACKEND_V2_JS_PATH; ?>users/edit.js"></script>