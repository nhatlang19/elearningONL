<!-- start: page -->
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(BACKEND_V2_TMPL_PATH . 'students/edit', ['id' => 'form', 'class' => 'form-horizontal form-bordered', 'autocomplete' => 'off']); ?>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>

				<h2 class="panel-title"><?php echo $title; ?></h2>
			</header>
			<div class="panel-body">
				<?php
                    $style = "hide";
                    $error = '';
                    if (($error = $this->session->flashdata('error'))) {
                        $style = '';
                        $this->session->set_flashdata('error', null);
                    }
                ?>
				<div class="alert alert-danger <?php echo $style; ?>">
                	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                	<?php echo $error; ?>
                </div>
				<?php echo validation_errors('<div class="alert alert-danger">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>', '</div>'); ?>
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Mã học sinh <span
						class="required">*</span>
					</label>
					<div class="col-md-6">
						<input name="indentity_number" type="text" class="form-control"
							id="inputDefault" required
							value="<?php echo isset($student->indentity_number) ? $student->indentity_number : ''; ?>">
							
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Tên học sinh <span
						class="required">*</span>
					</label>
					<div class="col-md-6">
						<input name="fullname" type="text" class="form-control"
							id="inputDefault" required
							value="<?php echo isset($student->fullname) ? $student->fullname : ''; ?>">
					</div>
				</div>
			</div>
			<div class="panel-body">
    			<div class="form-group">
    				<label class="col-md-3 control-label">Lớp</label>
    				<div class="col-md-6">
    					<select data-plugin-selectTwo class="form-control populate" name="class_id" id="class_id">
    						<?php 
    						foreach ($classes as $class) :
                                $selected = '';
                                if ($student && $class->class_id == $student->class_id) {
                                    $selected = 'selected="selected"';
                                }
                            ?>
    							<option <?php echo $selected; ?>
    							value="<?php echo $class->class_id; ?>"><?php echo $class->class_name; ?></option>
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
    						<?php 
    						foreach ($academics as $academic) :
                                $selected = '';
                                if ($student && $academic->academic_id == $student->academic_id) {
                                    $selected = 'selected="selected"';
                                }
                            ?>
    							<option <?php echo $selected; ?>
    							value="<?php echo $academic->academic_id; ?>"><?php echo $academic->academic_name; ?></option>
    						<?php endforeach; ?>
    					</select>
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
<script src="<?php echo BACKEND_V2_JS_PATH; ?>students/validation.js"></script>