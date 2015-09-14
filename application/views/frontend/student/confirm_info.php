<!doctype html>

<head>

<!-- Basics -->

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>Trắc nghiệm online :: Đăng nhập</title>

<!-- CSS -->
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootstrap.css">
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootswatch.min.css">
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
				<?php echo form_open('xac-nhan-thong-tin', ['id' => 'login', 'class' => 'form-horizontal']); ?>
					<fieldset>
						<legend>Xác nhận thông tin</legend>
						<div class="form-group">
							<label for="inputUsername" class="col-lg-3 control-label">Lớp</label>
							<div class="col-lg-9">
								<input type="text" readonly class="form-control" id="inputPassword"
									name="indentity_number" value="<?php echo $class_name;?>">
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword" class="col-lg-3 control-label">Mã số học sinh</label>
							<div class="col-lg-9">
								<input type="text" readonly class="form-control" id="inputPassword"
									name="indentity_number" value="<?php echo $indentity_number; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword" class="col-lg-3 control-label">Họ tên</label>
							<div class="col-lg-9">
								<input type="text" readonly class="form-control" id="inputPassword"
									name="indentity_number" value="<?php echo $fullname; ?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<button type="submit" class="btn btn-primary confirm">Xác nhận</button>
								<button type="button" class="btn btn-primary logout">Thoát</button>
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
	
	<script>
	$(document).ready(function() {
		$(".logout").click(function() {
			location.href = 'thoat';
		});
	});
	</script>
</body>

</html>
