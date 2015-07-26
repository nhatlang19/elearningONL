
<div id="main-content">
	<!-- Main Content Section with everything -->
	<?php echo form_open(BACKEND_V2_TMPL_PATH . 'topic/list_trash', array('name' => "adminForm", 'id' => 'adminForm')); ?>
	<!-- Page Head -->
	<h2>Quản lý đề thi(trash)</h2>

	<div class="filter"></div>



	<div class="clear"></div>
	<!-- End .clear -->

	<div class="content-box">
		<!-- Start Content Box -->

		<div class="content-box-header">

			<h3>Danh sách đề thi</h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<!-- This is the target div. id must match the href of this div's tab -->

				<table>

					<thead>
						<tr>
							<th>STT</th>
							<th>Tiêu đề</th>
							<th>Số câu</th>
							<th>Hình thức</th>
							<th>Niên khóa</th>
							<th>Ngày tạo</th>
							<th></th>
						</tr>

					</thead>
					<tfoot>
						<tr>
							<td colspan="7">
								<div class="bulk-actions align-left"></div>

								<div class="pagination">
									<?php echo $pagination->create_links(); ?>
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody id="">
						<?php
    $i = 1;
    foreach ($topics as $key => $value) :
        ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo ucfirst($value['title']); ?></td>
							<td><?php echo $value['number_questions']; ?> câu</td>
							<td><?php echo $value['etitle']; ?></td>
							<td><?php echo $value['academic_name']; ?></td>
							<td><?php echo setDate($value['created_time'], 'notime'); ?></td>
							<td><img src="<?php echo BACKEND_V2_IMAGE_PATH ?>cross.png"
								alt="Remove" title="Remove" class="imgRemove"
								id="<?php echo $value['topic_manage_id']; ?>" /> <img
								src="<?php echo BACKEND_V2_IMAGE_PATH ?>restore.png" alt="Restore"
								title="Restore" class="imgRestore"
								id="<?php echo $value['topic_manage_id']; ?>" /></td>
						</tr>
						<?php endforeach; ?>
					</tbody>

				</table>

			</div>
			<!-- End #tab1 -->

		</div>
		<!-- End .content-box-content -->

		<!-- </div>  End .content-box -->
		<?php echo form_close(); ?>
<script src="<?php echo BACKEND_V2_JS_PATH; ?>topic/list_trash.js"></script>