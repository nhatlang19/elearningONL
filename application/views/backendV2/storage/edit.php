<!-- start: page -->
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(BACKEND_V2_TMPL_PATH . 'storage/edit', ['id' => 'form', 'class' => 'form-horizontal form-bordered']); ?>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a> 
				</div>

				<h2 class="panel-title"><?php echo $title; ?></h2>
			</header>
			<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label" for="inputDefault">Tên kho <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="title" id="inputDefault" required value="<?php echo isset($storage->title) ? $storage->title : ''; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Chọn bộ môn</label>
						<div class="col-md-6">
							<select data-plugin-selectTwo class="form-control populate" name="subjects_id">
								<?php 
								foreach ($subjects as $item) :
								$selected = '';
								if (isset($storage->subjects_id) && $item->subjects_id == $storage->subjects_id) {
								    $selected = 'selected="selected"';
								}
								?>
									<option <?php echo $selected; ?>
									value="<?php echo $item->subjects_id; ?>"><?php echo $item->subjects_name; ?></option>
								<?php 
								endforeach; 
								?>
							</select>
						</div>
					</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-sm-9 col-sm-offset-3">
						<button class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-default">Reset</button>
					</div>
				</div>
			</footer>
			<input type='hidden' name='storage_id' id='id'
				value='<?php if(isset($id)) echo $id; ?>' />
		</section>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-validation/jquery.validate.js"></script>
<!-- Validate form -->
<script src="<?php echo BACKEND_V2_JS_PATH; ?>forms/form.validation.js"></script>