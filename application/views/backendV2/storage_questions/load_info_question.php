<h4><?php echo nl2br(stripslashes($storage_questions['question_name'])); ?></h4>
<div>
<?php
if (! $storage_questions['type']) :
    ?>
	<?php
    $i = 1;
    foreach ($storage_answer as $answer) :
        ?>
		<ul class="ulquestion">
		<li><b><?php echo $i; ?>. </b>
			<?php echo nl2br(stripslashes($answer['answer'])); ?>			
			<?php
        if ($answer['correct_answer'] == 1) :
            ?>
			<img src="<?php echo BACKEND_V2_IMAGE_PATH; ?>tick_circle.png" />
			<?php endif; ?>
			</li>
	</ul>
	<?php ++$i; endforeach; ?>
<?php else: ?>
	<?php
    $i = 1;
    foreach ($storage_answer as $answer) :
        ?>
		<ul class="ulquestion">
		<li><b><?php echo $i; ?>. </b> <img style="vertical-align: text-top;"
			class="thumb" src="<?php echo $answer['answer']; ?>" width="100" />
			<?php
        if ($answer['correct_answer'] == 1) :
            ?>
			<img src="<?php echo BACKEND_V2_IMAGE_PATH; ?>tick_circle.png" />
			<?php endif; ?>
			</li>
	</ul>
	<?php ++$i; endforeach; ?>
<?php endif; ?>
</div>
