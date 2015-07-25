<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administator | Đăng nhập</title>
<link rel="stylesheet" href="<?php echo BACK_END_CSS_PATH; ?>reset.css"
	type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo BACK_END_CSS_PATH; ?>style.css"
	type="text/css" media="screen" />
<link rel="stylesheet"
	href="<?php echo BACK_END_CSS_PATH; ?>invalid.css" type="text/css"
	media="screen" />
<script type="text/javascript"
	src="<?php echo BACK_END_JS_PATH; ?>jquery-1.3.2.min.js"></script>
<script type="text/javascript"
	src="<?php echo BACK_END_JS_PATH; ?>simpla.jquery.configuration.js"></script>
<script type="text/javascript"
	src="<?php echo BACK_END_JS_PATH; ?>facebox.js"></script>
<script type="text/javascript"
	src="<?php echo BACK_END_JS_PATH; ?>global.js"></script>
<script type="text/javascript"
	src="<?php echo BACK_END_JS_PATH; ?>jquery.wysiwyg.js"></script>
<script type="text/javascript"
	src="<?php echo BACK_END_JS_PATH; ?>jquery.datePicker.js"></script>
<script type="text/javascript"
	src="<?php echo BACK_END_JS_PATH; ?>jquery.date.js"></script>
</head>

<body id="login">

	<div id="login-wrapper" class="png_bg">
		<div id="login-top">

			<h1>Simpla Admin</h1>
			<!-- Logo (221px width) -->
			<img id="logo" src="<?php echo BACK_END_IMAGE_PATH; ?>logo.png"
				alt="Admin logo" />
		</div>
		<!-- End #logn-top -->

		<div id="login-content">
				
				<?php echo form_open(BACK_END_TMPL_PATH . 'users/login'); ?>
					<?php
    
    $style = "display: none;";
    $error = '';
    if ($this->session->userdata('error')) {
        $error = $this->session->userdata('error');
        $style = '';
        $this->session->unset_userdata('error');
    }
    ?>
					<div class="notification information error png_bg" style="<?php echo $style; ?>">
				<div>
							<?php echo $error; ?>
						</div>
			</div>

			<p>
				<label>Tên đăng nhập</label> <input class="text-input" type="text"
					name="username" />
			</p>
			<div class="clear"></div>
			<p>
				<label>Mật khẩu</label> <input class="text-input" type="password"
					name="password" />
			</p>
			<div class="clear"></div>

			<div class="clear"></div>
			<p>
				<input class="button" type="submit" value="Đăng nhập" />
			</p>
					
				<?php echo form_close(); ?>	
			</div>
		<!-- End #login-content -->

	</div>
	<!-- End #login-wrapper -->
</body>
</html>
