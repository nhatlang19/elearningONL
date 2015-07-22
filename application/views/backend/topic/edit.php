<div id="main-content">
	<!-- Main Content Section with everything -->


	<!-- Page Head -->


	<div class="clear"></div>
	<!-- End .clear -->

	<div class="content-box">
		<!-- Start Content Box -->

		<div class="content-box-header">

			<h3>
				<?php echo $title; ?>
			</h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->

		<div class="content-box-content">

			<div class="tab-content" id="tab1">

				<?php echo form_open_multipart(BACK_END_TMPL_PATH . 'topic/create'); ?>
				<div class="notification error png_bg" style="display: none">
					<a href="#" class="close"> <img
						src="<?php echo BACK_END_IMAGE_PATH; ?>cross_grey_small.png"
						title="Close this notification" alt="close" />
					</a>
					<div></div>
				</div>

				<fieldset>



					<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

					<p>
						<label>Tiêu đề</label> <input class="text-input medium-input"
							type="text" name="title" id="title" value="" />

					</p>

					<p>
						<label>Chọn kho câu hỏi</label> <select name="storage_id"
							id="storage_id" class="medium-input">
							<option value="-1">Chọn ...</option>
							<?php foreach($list_storage as $key => $item) : ?>
							<option value="<?php echo $item->storage_id; ?>">
								<?php echo $item->title; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</p>

					<p>
						<label>Chọn niên khóa</label> <select name="academic_id"
							id="academic_id" class="medium-input">
							<option value="-1">Chọn ...</option>
							<?php foreach($list_academic as $key => $item) : ?>
							<option value="<?php echo $item['academic_id']; ?>">
								<?php echo $item['academic_name']; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</p>

					<p>
						<label>Chọn hình thức thi</label> <select name="exam_id"
							id="exam_id" class="medium-input">
							<option value="-1">Chọn ...</option>
							<?php foreach($list_exam as $key => $item) : ?>
							<option value="<?php echo $item['exam_id']; ?>">
								<?php echo $item['title']; ?>
							</option>
							<?php endforeach; ?>
						</select>
					</p>

					<p>
						<label>Số lượng câu hỏi tối đa có thể</label> <input
							readonly="readonly"
							class="text-input medium-input number_question" type="text"
							name="number_question_max" id="number_question_max" value="0" />
					</p>

					<p>
						<label>Số lượng câu hỏi</label> <input maxlength="5"
							class="number_inp text-input medium-input number_question"
							type="text" name="number_question" id="number_question" />
					</p>

					<p>
						<label>Số đề thi</label> <input maxlength="5"
							class="number_inp text-input medium-input number_topic"
							type="text" name="number_topic" id="number_topic" />
					</p>


					<p>
						<input class="button" id="submit" type="submit"
							value="Tạo câu hỏi" /> <input class="button" type="button"
							value="Cancel" onclick="goback();" />
					</p>

				</fieldset>

				<div class="clear"></div>
				<!-- End .clear -->
				<?php echo form_close(); ?>

			</div>
			<!-- End #tab2 -->
		</div>
		<!-- End .content-box-content -->

		<!-- </div>  End .content-box -->
		<script type="text/javascript">
		$(document).ready(function() {
			var list = new Array();
			<?php $i = 0; foreach($list_storage as $key => $item) : ?>
			list[<?php echo $item->storage_id; ?>] = <?php echo $item->num_question; ?>;
			<?php endforeach; ?>

			$('#storage_id').change(function() {
				var val = $(this).val();				
				if(val != -1) {
					$('#number_question_max').val(list[val]);
				}
			});

			$('#submit').click(function() {			
				$('.error').hide();

				if($('#title').val() == '') {
					$('.error div').html('Hãy nhập tiêu đề');
					$('.error').show();
					//// $('html,body').animate({scrollTop: $("#error").offset().top},'1200');					
					return false;
				}

				if($('#storage_id').val() == -1) {
					$('.error div').html('Hãy chọn kho câu hỏi');
					$('.error').show();
					//// $('html,body').animate({scrollTop: $("#error").offset().top},'1200');					
					return false;
				}

				if($('#academic_id').val() == -1) {
					$('.error div').html('Hãy chọn niên khóa');
					$('.error').show();
					//// $('html,body').animate({scrollTop: $("#error").offset().top},'1200');					
					return false;
				}
				
				if($('#exam_id').val() == -1) {
					$('.error div').html('Hãy chọn hình thức thi');
					$('.error').show();
					//// $('html,body').animate({scrollTop: $("#error").offset().top},'1200');					
					return false;
				}

				if(!$('#number_question').val()) {
					$('.error div').html('Hãy nhập số câu hỏi');
					$('.error').show();
					//// $('html,body').animate({scrollTop: $("#error").offset().top},'1200');					
					return false;
				}
				
				if(!$('#number_topic').val()) {
					$('.error div').html('Hãy nhập số đề thi');
					$('.error').show();
					//// $('html,body').animate({scrollTop: $("#error").offset().top},'1200');					
					return false;
				}

				if(parseInt($('#number_question').val()) > parseInt($('#number_question_max').val())) {
					$('.error div').html('Số lượng câu hỏi không được lớn hơn ' + $('#number_question_max').val());
					$('.error').show();
					//// $('html,body').animate({scrollTop: $("#error").offset().top},'1200');					
					return false;
				}
						
				return true;				
			});

		});
		</script>