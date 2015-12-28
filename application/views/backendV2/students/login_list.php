<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/css/datatables.css" />
<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a> <a href="#"
				class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Danh sách học sinh đang đăng nhập</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="mb-md">
					<button id="startExam" class="btn btn-primary">
						Bắt đầu
					</button>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped mb-none" id="datatable-editable">
			<thead>
				<tr>
					<th>Mã số học sinh</th>
					<th>Tên học sinh</th>
					<th>Lớp</th>
					<th>Địa chỉ IP</th>
					<th>Ghi chú</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</section>
<?php echo $this->load->view(BACKEND_V2_TMPL_PATH . 'dialogs/dialog_delete', null, true); ?>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>students/login.editable.js"></script>
<ul id="chat_text_list">
</ul>
<script type="text/javascript">
var serverUrl = '<?php echo 'ws://' . $this->config->item('socket.ipserver') . ':' . $this->config->item('socket.port'); ?>';
</script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>admin_client.js"></script>