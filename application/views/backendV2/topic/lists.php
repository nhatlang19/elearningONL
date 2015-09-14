<link rel="stylesheet" href="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/css/datatables.css" />
<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="fa fa-caret-down"></a> <a href="#"
				class="fa fa-times"></a>
		</div>

		<h2 class="panel-title">Danh sách đề thi</h2>
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
					<th>Hình thức</th>
					<th>Niên khóa</th>
					<th style="text-align: center">Trạng thái</th>
					<th style="text-align: center">Hiện kết quả</th>
					<th style="text-align: center">Câu hỏi</th>
					<th style="text-align: center">Bài làm/Kết quả</th>
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
					<td style="text-align: center">
					<?php 
					if ($value->published) :
					?>
						<a href="javascript:void(0);" title="Đang mở"> <img
								src="<?php echo BACKEND_V2_IMAGE_PATH ?>tick_circle.png" />
						</a> <?php else: ?> <a
							href="published/<?php echo $value->topic_manage_id; ?>"
							title="Đang đóng"> <img
								src="<?php echo BACKEND_V2_IMAGE_PATH ?>cross_circle.png" />
						</a> <?php endif; ?>
					</td>
					<td style="text-align: center">
    					<?php
                            $checked = $value->review == 'SHOW' ? 'checked="checked"' : '';
                        ?>
    					<div class="switch switch-sm switch-primary">
    						<input data-id="<?php echo $value->topic_manage_id; ?>" type="checkbox" data-review="<?php echo $change_to; ?>" name="switch" data-plugin-ios-switch-preview <?php echo $checked; ?>  />
    					</div>
    					
					</td>
					<td style="text-align: center">
						<?php echo anchor(BACKEND_V2_TMPL_PATH . 'topic/export/' . $id, "<img src=\"" . BACKEND_V2_IMAGE_PATH . "rar.png\" />"); ?>
					</td>
					<td style="text-align: center">
						<a href="javascript:void(0);" class="showListStudentAnswer" id="<?php echo $value->topic_manage_id; ?>">
						<img src="<?php echo BACKEND_V2_IMAGE_PATH; ?>rar.png" />
						</a>
					</td>
					<td><?php echo setDate($value->created_time, 'notime'); ?></td>
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
<?php echo $this->load->view(BACKEND_V2_TMPL_PATH . 'topic/modal', null, true); ?>
<!-- Specific Page Vendor -->
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>ios7-switch/ios7-switch.js"></script>
<script src="<?php echo BACKEND_V2_VENDOR_PATH; ?>magnific-popup/magnific-popup.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>topic/datatables.editable.js"></script>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>topic/lists.js"></script>