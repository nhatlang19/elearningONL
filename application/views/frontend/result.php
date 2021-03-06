<?php echo $info_user; ?>
<br>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Thông tin cá nhân</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-6">
						<?php $student = $this->session->userdata('studentInfo'); ?>
						MSHS: <b><?php echo $student->indentity_number; ?></b><br> Họ tên:
						<b><?php echo $student->fullname; ?></b><br> Lớp: <b><?php echo $student->class_name; ?></b><br>
						Đề: <b><?php echo $code; ?></b>
					</div>
					<div class="col-md-6 text-center score"><?php echo $score['score']; ?> điểm</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(isset($topic_details)) : ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Câu trả lời</h3>
				</div>
				<div class="panel-body">
					<table class="table table-answer">
						<?php
    $maxCol = 5;
    $n = count($answers_student);
    $plus = $n < $maxCol ? $n : $maxCol;
    for ($i = 0; $i < $n; $i += $plus) :
        ?>
						<tr>
							<?php for($j = $i; $j < $i + $plus; $j++) :
							if(isset($answers_student[$j]->answer)) :
                                 $answers = explode(SEPARATE_CORRECT_ANSWER, $answers_student[$j]->answer);
    							 foreach ($answers as $key => $value) {
    							     $answers[$key] = Commonobj::convertNumberToChar((int)$value); 
    							 }
                                 $answer = implode(SEPARATE_CORRECT_ANSWER, $answers);
							?>
							<td><?php if($i < $n) echo $answers_student[$j]->number_question . '. ' . $answer; ?>
							</td>
							<?php else:?>
								<td></td>
							<?php endif; ?>
							<?php endfor; ?>
						</tr>
						<?php endfor; ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Chi tiết ( <?php echo $score['number_correct']; ?> trả lời đúng )</h3>
				</div>
				<div class="panel-body">
					<?php
    $list_answer = array(
        'a',
        'b',
        'c',
        'd'
    );
    $utils = new Utils();
    foreach ($topic_details as $key => $value) :
        $answers = explode('|||', $value['answer']);
        $positions = explode(',', $value['correct_answer']);
        $answer_of_student = @$list[$value['storage_question_id']];
        ?>
					<div class="quiz" id="slickQuiz" style="width: 100%">
						<blockquote>
							<?php echo ($key+1) . '. ' . $utils->changeLocalhostToServerIP($value['question_name']); ?>
							<?php echo !isset($answer_of_student->answer)?'<small class="no_answer">(Không có câu trả lời)</small>':''; ?>
						</blockquote>
						<div class="quizArea">
							<ul class="answers">
								<!-- where the quiz gets built -->
							<?php
        
		foreach ($answers as $k => $answer) :
            $correct = '';
            if (isset($answer_of_student->answer)) {
				$answerOfStudents = explode(SEPARATE_CORRECT_ANSWER, $answer_of_student->answer);
				if(in_array($k+1, $answerOfStudents)) {
					$correct = "<img src='" . BACKEND_V2_IMAGE_PATH . "cross_circle.png' />";
				}
            }
            if ($positions[$k]) {
                $correct = "<img src='" . BACKEND_V2_IMAGE_PATH . "tick_circle.png' />";
            }
            ?>
								<li><?php echo $list_answer[$k] . '. ' . $utils->changeLocalhostToServerIP($answer); ?> <?php echo $correct; ?></li> 
							<?php endforeach;?>
							</ul>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
