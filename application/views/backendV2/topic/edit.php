<script type="text/javascript">
var list = new Array();
<?php $i = 0; foreach($list_storage as $key => $item) : ?>
list[<?php echo $item->storage_id; ?>] = <?php echo $item->num_question; ?>;
<?php endforeach; ?>
</script>
<!-- start: page -->
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(BACKEND_V2_TMPL_PATH . 'topic/create', ['id' => 'form', 'class' => 'form-horizontal form-bordered', 'autocomplete' => 'off']); ?>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>

				<h2 class="panel-title"><?php echo $title; ?></h2>
			</header>
			<div class="panel-body">
				<?php echo validation_errors('<div class="alert alert-danger">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>', '</div>'); ?>
				<div class="form-group">
					<label class="col-md-3 control-label" for="title">Tiêu đề <span
						class="required">*</span>
					</label>
					<div class="col-md-6">
						<input name="title" type="text" class="form-control"
							id="title" required
							value="">
					</div>
				</div>
			</div>
			<div class="panel-body">
    			<div class="form-group">
    				<label class="col-md-3 control-label">Kho câu hỏi</label>
    				<div class="col-md-6">
    					<select data-plugin-selectTwo class="form-control populate" name="storage_id" id="storage_id">
    						<?php foreach($list_storage as $key => $item) : ?>
    							<option value="<?php echo $item->storage_id; ?>">
								<?php echo $item->title; ?>
								</option>
							<?php endforeach; ?>
    					</select>
    				</div>
    			</div>
    		</div>
    		<div class="panel-body">
    			<div class="form-group">
    				<label class="col-md-3 control-label">Niên khoá</label>
    				<div class="col-md-6">
    					<select data-plugin-selectTwo class="form-control populate" name="academic_id" id="academic_id">
    						<?php foreach($list_academic as $key => $item) : ?>
							<option value="<?php echo $item->academic_id; ?>">
								<?php echo $item->academic_name; ?>
							</option>
							<?php endforeach; ?>
    					</select>
    				</div>
    			</div>
    		</div>
    		<div class="panel-body">
    			<div class="form-group">
    				<label class="col-md-3 control-label">Chọn hình thức thi</label>
    				<div class="col-md-6">
    					<select data-plugin-selectTwo class="form-control populate" name="exam_id" id="exam_id">
    						<?php foreach($list_exam as $key => $item) : ?>
							<option value="<?php echo $item->exam_id; ?>">
								<?php echo $item->title; ?>
							</option>
							<?php endforeach; ?>
    					</select>
    				</div>
    			</div>
    		</div>
    		<div class="panel-body">
				<div class="form-group">
					<label class="col-md-3 control-label" for="number_question_max">Số lượng câu hỏi tối đa có thể
					</label>
					<div class="col-md-6">
						<input readonly="readonly" name="number_question_max" type="text" class="form-control"
							id="number_question_max"
							value="">
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-3 control-label" for="number_question">Số lượng câu hỏi <span
						class="required">*</span>
					</label>
					<div class="col-md-6">
						<input name="number_question" type="text" class="form-control"
							id="number_question"
							value="">
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-3 control-label" for="number_topic">Số đề thi <span
						class="required">*</span>
					</label>
					<div class="col-md-6">
						<input name="number_topic" type="text" class="form-control"
							id="number_topic"
							value="">
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-sm-9 col-sm-offset-3">
						<button class="btn btn-primary"><?php echo isset($id) ? 'Cập nhật' : 'Tạo mới'; ?></button>
						<button type="reset" class="btn btn-default">Phục hồi</button>
					</div>
				</div>
			</footer>
		</section>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_JS_PATH; ?>topic/edit.js"></script>
