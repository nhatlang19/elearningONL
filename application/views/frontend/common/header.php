<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]> <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]> <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Trắc nghiệm online :: <?php echo $title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>document.write('<script src="<?php echo JS_PATH; ?>vendor/jquery-1.10.2.min.js"><\/script>')</script>
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>normalize.css">
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>main.css">
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>style.css">
<link href="<?php echo CSS_PATH; ?>master.css" media="screen"
	rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootstrap.css">
<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootswatch.min.css">
<link href="<?php echo CSS_PATH; ?>slickQuiz.css" media="screen"
	rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css"
	href="<?php echo CSS_PATH; ?>fancybox2/jquery.fancybox.css?v=2.1.5"
	media="screen" />
<link rel="stylesheet" type="text/css"
	href="<?php echo CSS_PATH; ?>fancybox2/jquery.fancybox-buttons.css?v=1.0.5" />
<link rel="stylesheet" type="text/css"
	href="<?php echo CSS_PATH; ?>fancybox2/jquery.fancybox-thumbs.css?v=1.0.7" />

<script src="<?php echo JS_PATH; ?>vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
<?php
$student = $this->session->userdata('studentInfo');
?>
<script type="text/javascript">
var _TIME = <?php echo (isset($minute) && $minute)?$minute:15; ?>;
var _CNAME = 'periods<?php echo $student->student_id; ?>';
var BASEURL = '<?php echo base_url(); ?>';
var _LOGOUT = false;
</script>