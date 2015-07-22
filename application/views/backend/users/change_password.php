<div id="main-content">
	<!-- Main Content Section with everything -->


	<!-- Page Head -->
	<h2>Change Password</h2>
	<p id="page-intro"></p>



	<div class="clear"></div>
	<!-- End .clear -->
	<?php
		if($this->session->userdata('error_change')) { 
			$style = "display: none;";
			if ($this->session->userdata ( 'error_change' )) {
				$error = $this->session->userdata ( 'error_change' );
				$style = '';
				$this->session->unset_userdata ( 'error_change' );
			}
		?>
		<div class="notification information error png_bg" style="<?php echo $style; ?>">
			<div>
				<?php echo $error; ?>
			</div>
		</div>
		<?php } ?>
		<?php if($this->session->userdata('success_change')) { ?>
		<div id="report">		
			<?php					
				$style = "display: none;";									
				$success = $this->session->userdata('success_change');
				$style = '';
				$this->session->unset_userdata('success_change');
				
			?>
			<meta http-equiv="refresh" content="5; URL=<?php echo site_url(BACK_END_TMPL_PATH . 'dashboard'); ?>">
			<div class="notification information success png_bg" style="<?php echo $style; ?> margin-bottom: 100px;">
				<div>
					<?php echo $success; ?>
				</div>
				<div style="text-align: center">Vui lòng chờ trong 5 giây. Click vào <?php echo anchor(site_url(BACK_END_TMPL_PATH . 'dashboard'), 'đây')?> để không phải chờ lâu</div>						
				<br clear='all' />
			</div>
										
		<?php } else {?>
	<div class="content-box">
		<!-- Start Content Box -->

		<div class="content-box-header">

			<h3>Edit</h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->
		
		
		<div class="content-box-content">

			<div class="tab-content" id="tab1">
				

				<?php echo form_open_multipart(BACK_END_TMPL_PATH . 'users/save'); ?>

					<fieldset>
					<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->


					<p>
						<label>Mật khẩu mới</label> <input type="password"
							class="text-input small-input" name="pass" id="passfield" value="" />
						<span class="input-error" id="error_name"></span>
					</p>
					<p>
						<label>Xác nhận mật khẩu</label> <input type="password"
							class="text-input small-input" name="re-pass" id="re-pass"
							value="" /> <span class="input-error" id="error_name"></span>
					</p>					
					<p>
						<input class="button" type="submit" value="Submit" />
					</p>

				</fieldset>

				<div class="clear"></div>
				<!-- End .clear -->
				<?php echo form_close(); ?>	
				
			</div>
			<!-- End #tab2 -->



		</div>
		<!-- End .content-box-content -->

		<!-- </div>  End .content-box -->
<?php } ?>