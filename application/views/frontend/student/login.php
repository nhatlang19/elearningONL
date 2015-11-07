<!doctype html>

<head>

<!-- Basics -->

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>Trắc nghiệm online :: Đăng nhập</title>
<meta property="og:title" content="Elearning Online">
        <meta property="og:description" content="Elearning Online">
        <meta property="og:site_name" content="Elearning Online">
        <meta property="og:image" content="<?php echo ROOT . '/public/elearning-icon.png'; ?>">
		<link rel="shortcut icon" href="<?php echo ROOT . '/public/favicon.ico'; ?>" type="image/x-icon" >
<!-- CSS -->
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootstrap.css">
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootswatch.min.css">
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
</head>

<!-- Main HTML -->

<body>

	<!-- Begin Page Content -->
	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<?php if(isset($error)): ?>
				<div class="alert alert-dismissable alert-danger">
					<strong><?php echo $error; ?></strong>
				</div>
				<?php endif; ?>
				<?php echo form_open('dang-nhap', ['id' => 'login', 'class' => 'form-horizontal']); ?>
					<fieldset>
						<legend>Đăng nhập</legend>
						<div class="form-group">
						<label for="inputUsername" class="col-lg-3 control-label">Lớp</label>
							<div class="col-lg-9">
								<select class="form-control clazz" name="class_id">
                                <?php 
        						foreach ($classes as $class) :
                                ?>
    								<option	value="<?php echo $class->class_id; ?>"><?php echo $class->class_name; ?></option>
    							<?php endforeach; ?>
                                </select>	
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword" class="col-lg-3 control-label">Mã số học sinh</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" id="inputPassword"
									name="indentity_number" placeholder="Mã số học sinh">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<button type="submit" class="btn btn-primary">Đăng nhập</button>
							</div>
						</div>
					</fieldset>
				<?php echo form_close(); ?>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>


	<!-- End Page Content -->
	<script>document.write('<script src="<?php echo JS_PATH; ?>vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="<?php echo JS_PATH; ?>bootstrap.min.js"></script>
	<script src="<?php echo JS_PATH; ?>bootswatch.js"></script>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
	<script>
	$(document).ready(function() {
		  $(".clazz").select2();
	});
	</script>
</body>

</html>
