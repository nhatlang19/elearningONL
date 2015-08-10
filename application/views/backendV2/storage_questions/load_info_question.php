<div id="modalHeaderColorPrimary" class="modal-block modal-header-color modal-block-primary">
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title"><?php echo nl2br(stripslashes($storage_questions->question_name)); ?></h2>
	</header>
	<div class="panel-body">
		<div class="modal-wrapper">
			<div class="modal-icon"></div>
			<div class="modal-text">
	<?php
        $i = 1;
        foreach ($storage_answer as $answer) :
            ?>
    		<p>
    		<b><?php echo $i; ?>. </b>
			<?php echo nl2br(stripslashes($answer->answer)); ?>			
			<?php
            if ($answer->correct_answer == 1) :
                ?>
			<img src="<?php echo BACKEND_V2_IMAGE_PATH; ?>tick_circle.png" />
			<?php endif; ?>
			</p>
	<?php ++$i; endforeach; ?>
			</div>
		</div>
	</div>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-md-12 text-right">
				<button class="btn btn-primary modal-confirm">Close</button>
			</div>
		</div>
	</footer>
</section>
</div>