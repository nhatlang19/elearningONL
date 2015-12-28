<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>dropzone/css/basic.css" />		
<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>dropzone/css/dropzone.css" />
<div id="modalHeaderColorPrimary" class="modal-block modal-header-color modal-block-primary mfp-hide">
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Tạo kho câu hỏi từ tệp (.docx)</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
			<?php echo form_open(BACKEND_V2_TMPL_PATH . 'storage/uploadfile', ['id' => 'dropzone-example', 'class' => 'dropzone dz-square']); ?>
				<input class="storage_id" type="hidden" name="storage_id"
				id="storage_id" value="" />
			<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-md-9 text-left">
				<div>Tại về tệp mẫu tại <a
				href="<?php echo BACKEND_V2_TEMPLATES_PATH; ?>template_import_questions.docx">đây</a></div>
			</div>
			<div class="col-md-3 text-right">
				<button class="btn btn-primary modal-confirm">Close</button>
			</div>
		</div>
	</footer>
</section>

</div>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>dropzone/dropzone.js"></script>