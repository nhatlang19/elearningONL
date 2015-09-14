	<?php echo $info_user; ?>
<!-- hien thi cac cau hoi & cau tra loi -->
<script>
	// Setup your quiz text and questions here

	// NOTE: pay attention to commas, IE struggles with those bad boys

	var quizJSON = {
		"info" : {
		},
		"questions" : <?php echo $jsonData; ?>
	};
	</script>
<div class="col-lg-12">
	<h2 id="type-blockquotes">Đề <?php echo $code; ?></h2>
</div>
<form name="myform" id="myform" action="save" method="post">
	<input type="hidden" name="topic_id" value="<?php echo $code; ?>" />
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title quiz">Thi trắc nghiệm</h3>
						<span id="hidden" style="display: none"></span> <span
							id="countDown"></span>
					</div>
					<div class="panel-body">
						<div class="quiz-container">
							<div class="quiz" id="slickQuiz">
								<h1 class="quizName">
									<!-- where the quiz name goes -->
								</h1>
								<div class="quizArea">
									<div class="quizHeader">
										<!-- where the quiz main copy goes -->
										<a class="startQuiz btn btn-primary" href="#">Bắt đầu làm bài</a>
									</div>

									<!-- where the quiz gets built -->
								</div>

								<div class="quizResults">
									<h3 class="quizScore">
										You Scored: <span> <!-- where the quiz score goes -->
										</span>
									</h3>

									<h3 class="quizLevel">
										<strong>Ranking:</strong> <span> <!-- where the quiz ranking level goes -->
										</span>
									</h3>

									<div class="quizResultsCopy">
										<!-- where the quiz result copy goes -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Câu trả lời</h3>
					</div>
					<div class="panel-body">
						<div class="quiz-container answer-user"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script src="<?php echo JS_PATH; ?>slickQuiz.js"></script>
<script src="<?php echo JS_PATH; ?>master.js"></script>
<script>
$(function () {
	$(window).bind('beforeunload', function(e) {    
		return 'Bạn không nên refresh hay tắt trình duyệt khi chưa lưu bài';
	});

	$(document).bind("contextmenu", function(e) {
	    return false;
	});
	
	$("html, body").keydown(false);
});
</script>