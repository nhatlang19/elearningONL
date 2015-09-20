<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/css/datatables.css" />
<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a> <a href="#"
				class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Danh sách câu hỏi</h2>
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
					<th>Câu hỏi</th>
					<th>Tên kho</th>
					<th>Thời gian tạo</th>
					<th style="text-align: center;">Trạng thái</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
                    $i = 1;
                    foreach ($lists as $key => $value) :
                ?>
				<tr class="gradeX" data-id="<?php echo $value->storage_question_id; ?>">
					<td><?php echo $i++; ?></td>
					<td>
    					<a class="sq-ajax-modal" href="<?php echo site_url(BACKEND_V2_TMPL_PATH . 'storage-question/view/' . $value->storage_question_id); ?>">
    					<?php echo word_limiter(sanitizeText($value->question_name), 6); ?>
    					</a>
					<td><?php echo $value->title; ?></td>
					<td><?php echo setDate($value->updated_time, 'time'); ?></td>
					<td style="text-align: center">
					<?php
                        $checked = $value->published ? 'checked="checked"' : '';
                    ?>
    					<div class="switch switch-sm switch-primary">
    						<input type="checkbox" name="switch" data-plugin-ios-switch <?php echo $checked; ?>  />
    					</div>
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
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>ios7-switch/ios7-switch.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>magnific-popup/magnific-popup.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>storage_questions/datatables.editable.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>storage_questions/modals.js"></script>