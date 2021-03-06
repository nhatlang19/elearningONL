<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>bootstrap-fileupload/bootstrap-fileupload.min.css" />
<!-- start: page -->
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open_multipart(BACKEND_V2_TMPL_PATH . 'students/import', ['id' => 'form', 'class' => 'form-horizontal form-bordered', 'autocomplete' => 'off']); ?>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>

				<h2 class="panel-title">Thêm học sinh từ tệp 
				</h2>
			</header>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Chọn file</label>
					<div class="col-md-6">
						<div class="fileupload fileupload-new" data-provides="fileupload" data-name="uploadfile">
							<div class="input-append">
								<div class="uneditable-input">
									<i class="fa fa-file fileupload-exists"></i>
									<span class="fileupload-preview"></span>
									
								</div>
								<span class="btn btn-default btn-file">
									<span class="fileupload-exists">Change</span>
									<span class="fileupload-new">Select file</span>
									<input type="file" />
								</span>
								<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div>
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
                            ?>
    							<option value="<?php echo $class->class_id; ?>"><?php echo $class->class_name; ?></option>
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
                            ?>
    							<option
    							value="<?php echo $academic->academic_id; ?>"><?php echo $academic->academic_name; ?></option>
    						<?php endforeach; ?>
    					</select>
    				</div>
    			</div>
    		</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-sm-9 col-sm-offset-3">
						<button class="btn btn-primary" onclick="$('.fileupload').fileupload();">Submit</button>
						<button type="reset" class="btn btn-default">Phục hồi</button>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-9">
						(Tải về tệp mẫu tại <a
							href="<?php echo BACKEND_V2_TEMPLATES_PATH; ?>template_student_lists.xls">đây</a>)
					</div>
				</div>
			</footer>
		</section>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
