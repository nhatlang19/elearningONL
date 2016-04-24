<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/css/datatables.css" />
<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a> <a href="#"
				class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Danh sách học sinh</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="mb-md">
					<button id="addToTable" class="btn btn-primary">
						Tạo mới <i class="fa fa-plus"></i>
					</button>
					<button id="importToTable" class="btn btn-primary">
						Import <i class="fa fa-plus"></i>
					</button>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped mb-none" id="datatable-editable">
			<thead>
				<tr>
					<th align="center">STT</th>
					<th>Mã số học sinh</th>
					<th>Tên học sinh</th>
					<th>Lớp</th>
					<th>Xử lý</th>
				</tr>
			</thead>
			<tbody>
				<?php
                    $i = 1;
                    foreach ($lists as $key => $value) :
                ?>
				<tr class="gradeX" data-id="<?php echo $value->student_id; ?>">
					<td><?php echo $i++; ?></td>
					<td><?php echo $value->indentity_number; ?></td>
					<td><?php echo anchor(BACKEND_V2_TMPL_PATH . 'students/edit/' . $value->student_id, $value->fullname); ?></td>
					<td><?php echo $value->class_name; ?></td>
					<td class="actions">
						<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
						<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>
<?php echo $this->load->view(BACKEND_V2_TMPL_PATH . 'dialogs/dialog_delete', null, true); ?>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>magnific-popup/magnific-popup.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>students/datatables.editable.js"></script>
