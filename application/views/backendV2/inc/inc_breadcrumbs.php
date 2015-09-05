<?php
$controller = $this->uri->segment(2);
$action = $this->uri->segment(3);
?>
<header class="page-header">
	<h2></h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li><a href="<?php echo site_url(BACKEND_V2_TMPL_PATH . 'dashboard'); ?>"> <i class="fa fa-home"></i>
			</a></li>
			<li><a href="<?php echo site_url(BACKEND_V2_TMPL_PATH . $controller); ?>"><span><?php echo $controller . $this->lang->line($controller); ?></span></a></li>
			<li><span></span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i
			class="fa fa-chevron-left"></i></a>
	</div>
</header>


<script type="text/javascript">
$(document).ready(function() {			
	$('.page-header h2').text($('.panel-heading h2:first').text());
	$('.breadcrumbs li:last span').text($('.panel-heading h2:first').text());
});
</script>