<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/css/datatables.css" />
<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a> <a href="#"
				class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Danh sách đề thi(trash)</h2>
	</header>
	<div class="panel-body">
		<table class="table table-bordered table-striped mb-none" id="datatable-editable">
			<thead>
				<tr>
					<th>STT</th>
					<th>Tiêu đề</th>
					<th>Hình thức</th>
					<th>Niên khóa</th>
					<th>Ngày tạo</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
                $i = 1;
                foreach ($topics as $key => $value) :
                    $id = md5(date('Ymd')) . 'tid' . $value->topic_manage_id;
                    
                    $change_to = $value->review == 'SHOW' ? 'hide' : 'show';
                ?>
				<tr class="gradeX" data-id="<?php echo $value->topic_manage_id; ?>">
					<td><?php echo $i++; ?></td>
					<td><?php echo anchor(BACKEND_V2_TMPL_PATH . 'topic/edit/' . $value->topic_manage_id, ucfirst($value->title)); ?> (<?php echo $value->number_questions; ?> câu)</td>
					<td><?php echo $value->etitle; ?></td>
					<td><?php echo $value->academic_name; ?></td>
					<td><?php echo setDate($value->created_time, 'notime'); ?></td>
					<td class="actions">
						<a href="#" class="on-default restore-row">
						<img src="<?php echo BACKEND_V2_IMAGE_PATH ?>restore.png" 
							alt="Phục hồi"	title="Phục hồi"
						 />
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>
<?php echo $this->load->view(BACKEND_V2_TMPL_PATH . 'dialogs/dialog_restore', null, true); ?>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>ios7-switch/ios7-switch.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>magnific-popup/magnific-popup.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>topic/trash.datatables.editable.js"></script>
