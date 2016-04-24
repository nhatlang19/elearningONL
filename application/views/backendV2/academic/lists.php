<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/css/datatables.css" />
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
<?php echo $error; ?>.
</div>
<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a> <a href="#"
				class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Danh sách niên khoá</h2>
	</header>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="mb-md">
					<button id="addToTable" class="btn btn-primary">
						Tạo mới <i class="fa fa-plus"></i>
					</button>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped mb-none" id="datatable-editable">
			<thead>
				<tr>
					<th align="center">STT</th>
					<th>Niên khoá</th>
					<th>Mặc định</th>
					<th>Xử lý</th>
				</tr>
			</thead>
			<tbody>
				<?php
                    $i = 1;
                    foreach ($lists as $key => $value) :
                ?>
				<tr class="gradeX" data-id="<?php echo $value->academic_id; ?>">
					<td><?php echo $i++; ?></td>
					<td><?php echo anchor(BACKEND_V2_TMPL_PATH . 'academic/edit/' . $value->academic_id, $value->academic_name); ?></td>
					<?php /* <td style="text-align: center">
					<?php
                        $checked = $value->published ? 'checked="checked"' : '';
                        $status = $value->published ? 'unpublished"' : 'published';
                    ?>
    					<div class="switch switch-sm switch-primary">
    						<input type="checkbox" name="switch" data-plugin-ios-switch <?php echo $checked; ?> data-id="<?php echo $value->academic_id; ?>" data-status="<?php echo $status; ?>"  />
    					</div>
					</td> */ ?>
					<td style="text-align: center">
						<?php if(!$value->default) :?>
    					<a href="<?php echo site_url(BACKEND_V2_TMPL_PATH . 'academic/setDefault/' . $value->academic_id); ?>" class="on-default"><span class="label label-primary">Set Default</span></a>
    					<?php else: ?>
    					<span class="label label-success">Default</span>
    					<?php endif; ?>
					</td>
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
<script src="<?php echo BACKEND_V2_JS_PATH; ?>academic/datatables.editable.js"></script>
