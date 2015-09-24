<!-- start: page -->
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(BACKEND_V2_TMPL_PATH . 'academic/edit', ['id' => 'form', 'class' => 'form-horizontal form-bordered']); ?>
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
					<label class="col-md-3 control-label" for="inputDefault">Niên khoá <span
						class="required">*</span>
					</label>
					<div class="col-md-6">
						<input name="academic_name" maxlength="255" type="text" class="form-control"
							id="inputDefault" required
							value="<?php echo isset($academic->academic_name) ? $academic->academic_name : ''; ?>">
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
<script src="<?php echo BACKEND_V2_JS_PATH; ?>academic/validation.js"></script>