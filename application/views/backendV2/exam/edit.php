<!-- start: page -->
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(BACKEND_V2_TMPL_PATH . 'exam/edit', ['id' => 'form', 'class' => 'form-horizontal form-bordered']); ?>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>

				<h2 class="panel-title"><?php echo $title; ?></h2>
			</header>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Hình thức thi <span
						class="required">*</span>
					</label>
					<div class="col-md-6">
						<input name="title" type="text" class="form-control"
							id="inputDefault" required
							value="<?php echo isset($exam->title) ? $exam->title : ''; ?>">
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Thời gian ( phút ) <span
						class="required">*</span>
					</label>
					<div class="col-md-6">
						<input name="time" type="text" class="form-control"
							id="inputDefault" required
							value="<?php echo isset($exam->time) ? $exam->time : ''; ?>">
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
			<input type='hidden' name='id' id='id'
				value='<?php if(isset($id)) echo $id; ?>' />
		</section>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- Specific Page Vendor -->
<script
	src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-validation/jquery.validate.js"></script>
<!-- Validate form -->
<script src="<?php echo BACKEND_V2_JS_PATH; ?>forms/form.validation.js"></script>