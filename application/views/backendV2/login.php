<!doctype html>
<html class="fixed">
	<head>
		<title>Administrator | Đăng nhập</title>
		<!-- Basic -->
		<meta charset="UTF-8" />

		<meta name="keywords" content="Elearning Online Admin Template" />
		<meta name="description" content="Elearning Online" />
		<meta name="author" content="nhatlang19@gmail.com" />

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css" />

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>font-awesome/css/font-awesome.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo BACKEND_V2_CSS_PATH; ?>theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo BACKEND_V2_CSS_PATH; ?>skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo BACKEND_V2_CSS_PATH; ?>theme-custom.css" />

		<!-- Head Libs -->
		<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>modernizr/modernizr.js"></script>

	</head>
	<body>
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				<a href="/" class="logo pull-left">
					<img src="<?php echo BACKEND_V2_IMAGE_PATH; ?>logo.png" height="54" alt="Porto Admin" />
				</a>
<?php
    $style = "hide";
    $error = '';
    if (($error = $this->session->flashdata('error'))) {
        $style = '';
        $this->session->set_flashdata('error', null);
    }
?>
				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Đăng nhập</h2>
					</div>
					<div class="panel-body">
						<div class="alert alert-danger <?php echo $style; ?>">
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                            <?php echo $error; ?>.
						</div>
						<?php echo form_open(BACKEND_V2_TMPL_PATH . 'users/login', ['id' => 'form']); ?>
							<div class="form-group mb-lg">
								<label>Tên đăng nhập <span class="required">*</span></label>
								<div class="input-group input-group-icon">
									<input name="username" type="text" value="<?php echo $username; ?>" class="form-control input-lg" required />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="form-group mb-lg">
								<div class="clearfix">
									<label class="pull-left">Mật khẩu <span class="required">*</span></label>
									<a href="pages-recover-password.html" class="pull-right">Quên mật khẩu?</a>
								</div>
								<div class="input-group input-group-icon">
									<input name="password" type="password" class="form-control input-lg"  required />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8">
								</div>
								<div class="col-sm-4 text-right">
									<button type="submit" class="btn btn-primary hidden-xs">Đăng nhập</button>
									<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Đăng nhập</button>
								</div>
							</div>

						<?php echo form_close(); ?>	
					</div>
				</div>
				
				<p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date('Y'); ?>. All Rights Reserved.</p>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery/jquery.js"></script>
		<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>bootstrap/js/bootstrap.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-validation/jquery.validate.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo BACKEND_V2_JS_PATH; ?>theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo BACKEND_V2_JS_PATH; ?>theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo BACKEND_V2_JS_PATH; ?>theme.init.js"></script>
		
		<!-- Validate form -->
		<script src="<?php echo BACKEND_V2_JS_PATH; ?>forms/form.validation.js"></script>

	</body>
</html>
