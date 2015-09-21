<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/css/datatables.css" />
<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a> <a href="#"
				class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Quản lý kho câu hỏi</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="mb-md">
					<button id="addToTable" class="btn btn-primary">
						Add <i class="fa fa-plus"></i>
					</button>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped mb-none" id="datatable-editable">
			<thead>
				<tr>
					<th align="center">STT</th>
					<th>Tiêu đề</th>
					<th>Thời gian</th>
					<th>Số câu hỏi</th>
					<th>Bộ môn</th>
					<th>Export</th>
					<th>Import</th>
					<th>Trạng thái</th>
					<th>Id</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
                    $i = 1;
                    foreach ($lists as $key => $value) :
                ?>
				<tr class="gradeX" data-id="<?php echo $value->storage_id; ?>" id="tr<?php echo $value->storage_id; ?>">
					<td><?php echo $i++; ?></td>
					<td><?php echo anchor(BACKEND_V2_TMPL_PATH . 'storage/edit/' . $value->storage_id, $value->title); ?></td>
					<td><?php echo setDate($value->updated_time, 'notime'); ?></td>
					<td class="num-question" style="text-align: center"><?php echo $value->num_question; ?></td>
					<td><?php echo $value->subjects_name; ?></td>
					<td><?php echo anchor(BACKEND_V2_TMPL_PATH . 'storage/export/' . $value->storage_id, 'Export'); ?></td>
					<td><a id="<?php echo $value->storage_id; ?>" class="mb-xs mt-xs mr-xs modal-basic"
						href="#modalHeaderColorPrimary" rel="modal">Import</a></td>
					<td style="text-align: center">
					<?php
                        $checked = $value->published ? 'checked="checked"' : '';
                    ?>
    					<div class="switch switch-sm switch-primary">
    						<input type="checkbox" name="switch" data-plugin-ios-switch <?php echo $checked; ?>  />
    					</div>
					</td>
					<td><?php echo $value->storage_id; ?></td>
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
<?php echo $this->load->view(BACKEND_V2_TMPL_PATH . 'storage/import', null, true); ?>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>magnific-popup/magnific-popup.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>storage/modals.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>storage/datatables.editable.js"></script>