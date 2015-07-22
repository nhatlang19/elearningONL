<!doctype html>

<head>

<!-- Basics -->

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>Trắc nghiệm online :: Đăng nhập</title>

<!-- CSS -->
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootstrap.css">
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootswatch.min.css">
<style type="text/css">
<!--
.container {
	top: 50%;
	left: 50%;
	margin-top: 100px;
}
-->
</style>
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
				<form class="form-horizontal" method="post" id="login">
					<fieldset>
						<legend>Đăng nhập</legend>
						<div class="form-group">
							<label for="inputUsername" class="col-lg-3 control-label">Tên
								đăng nhập</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" id="inputUsername"
									name="username" placeholder="Tên đăng nhập">
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword" class="col-lg-3 control-label">Mật
								khẩu</label>
							<div class="col-lg-9">
								<input type="password" class="form-control" id="inputPassword"
									name="password" placeholder="Mật khẩu">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>


	<!-- End Page Content -->
	<script>document.write('<script src="<?php echo JS_PATH; ?>vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="<?php echo JS_PATH; ?>bootstrap.min.js"></script>
	<script src="<?php echo JS_PATH; ?>bootswatch.js"></script>
</body>

</html>
