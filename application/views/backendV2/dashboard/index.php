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

		<h2 class="panel-title">Trạng thái hệ thống</h2>
	</header>
	<div class="panel-body">
		<table class="table table-bordered table-striped mb-none" id="datatable-editable">
			<thead>
				<tr>
					<th align="center">STT</th>
					<th>Thông báo</th>
					<th>Trạng thái</th>
					<th>Xử lý</th>
				</tr>
			</thead>
			<tbody>
				<?php
                    $i = 1;
                    foreach ($stats as $key => $value) :
                        if(empty($value)) :
                            continue;
                        endif;
                ?>
				<tr class="gradeX">
					<td><?php echo $i++; ?></td>
					<td><?php echo $value['message']; ?></td>
					<td><span class="label label-warning">Warning</span></td>
					<td class="actions">
						<a href="<?php echo site_url($value['uri']); ?>" class="on-default"><span class="label label-primary">Hiển thị danh sách</span></a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>magnific-popup/magnific-popup.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>dashboard/datatables.editable.js"></script>