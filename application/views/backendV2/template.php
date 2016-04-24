<?php echo $head; ?>
<?php echo $header; ?>
<div class="inner-wrapper">
<?php echo $sidebar; ?>
	<section role="main" class="content-body">
		<?php // echo $breadcrumbs; ?>
    	<?php if(isset($content)) echo $content; ?>
    </section>
</div>
<?php echo $footer; ?>
<?php echo $debug; ?>

	
