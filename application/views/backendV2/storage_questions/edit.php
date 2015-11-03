<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>summernote/summernote.css" />
<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>summernote/summernote-bs3.css" />
<!-- start: page -->
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(BACKEND_V2_TMPL_PATH . 'storage-question/save', ['id' => 'form', 'class' => 'form-horizontal form-bordered', 'autocomplete' => 'off']); ?>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a> 
				</div>

				<h2 class="panel-title"><?php echo $title; ?></h2>
			</header>
			<div class="panel-body">
					<?php if(isset($error)) : ?>
					<div class="alert alert-danger">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                        <?php echo $error; ?>.
					</div>
					<?php endif; ?>
					<div class="form-group">
						<label class="col-md-3 control-label">Chọn kho</label>
						<div class="col-md-6">
							<select data-plugin-selectTwo class="form-control populate" name="storage" id="storage">
								<?php 
								foreach ($storage as $item) :
                                    $selected = '';
                                    if ($storage_question && $item->storage_id == $storage_questions->storage_id) {
                                        $selected = 'selected="selected"';
                                    }
                                ?>
    								<option <?php echo $selected; ?>
    								value="<?php echo $item->storage_id; ?>"><?php echo $item->title; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="inputDefault">Câu hỏi <span class="required">*</span></label>
						<div class="col-md-9">
							<div class="summernote question_name" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }'>
							<?php echo isset($storage_question->question_name) ? stripslashes($storage_question->question_name) : ''; ?>
							</div>
						</div>
					</div>
					<?php 
						$step = 0;
						for($i=97;$i< 101;$i++) : ?>
					<div class="form-group">
						<label class="col-md-3 control-label"><?php if(!$step) : ?>Câu trả lời:<?php endif; ?></label>
						<div class="col-md-1">
							<?php echo chr($i); ?>. <input type="checkbox" name="correct_answer"
								<?php if(isset($storage_answer[$step]->correct_answer) && $storage_answer[$step]->correct_answer == 1) echo 'checked="checked"'; ?>
								class="checkbox-answer" value="<?php echo $step; ?>" />
						</div>
						<div class="col-md-8">
							<div class="summernote answer_name" data-plugin-summernote data-plugin-options='{ "height": 100, "codemirror": { "theme": "ambiance" } }'>
							<?php if(isset($storage_answer[$step]->answer)) echo stripslashes($storage_answer[$step]->answer); ?>
							</div>
						</div>
					</div>
					<?php $step++; endfor; ?>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-sm-9 col-sm-offset-3">
						<button class="btn btn-primary"><?php echo isset($id) ? 'Cập nhật' : 'Tạo mới'; ?></button>
						<button type="reset" class="btn btn-default">Phục hồi</button>
					</div>
				</div>
			</footer>
			<input type='hidden' name='id' id='id'
				value='<?php if(isset($id)) echo $id; ?>' />
		</section>
		<?php echo form_close(); ?>
	</div>
</div>


<script type="text/javascript">

$( "form" ).submit(function( event ) {
	event.preventDefault();
	var $form = $(this);
	var formData = $(this).serializeArray();

	var object = {name:"question_name", value:$('.question_name').code()}; 
	formData.push(object);

	$.each( $('.answer_name'), function( key, value ) {
		var object = {name:"answer_name[]", value:$('.answer_name').code()}; 
		formData.push(object);
	});
	
	console.log(formData);
	$.ajax({
        url: $form.attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(result) {
            console.log(result);
//             location.href = 'list.html';
        }
    });
});
</script>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-validation/jquery.validate.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>summernote/summernote.js"></script>
<!-- Validate form -->
<script src="<?php echo BACKEND_V2_JS_PATH; ?>forms/form.validation.js"></script>