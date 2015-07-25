
<div id="main-content">
	<!-- Main Content Section with everything -->
	<?php echo form_open(BACK_END_TMPL_PATH . 'topic/save', array('name' => "adminForm", 'id' => 'adminForm')); ?>
	<!-- Page Head -->
	<h2>Quản lý đề thi</h2>

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
							<th style="text-align: center">Trạng thái</th>
							<th style="text-align: center">Kết quả</th>
							<th style="text-align: center">Câu hỏi</th>
							<th style="text-align: center">Bài làm/Kết quả</th>
							<th>Ngày tạo</th>
							<th></th>
						</tr>

					</thead>
					<tfoot>
						<tr>
							<td colspan="12">
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
        $id = md5(date('Ymd')) . 'tid' . $value['topic_manage_id'];
        
        $review = $value['review'] == 'SHOW' ? 'Hiện' : 'Ẩn';
        $tdStyle = $value['review'] == 'SHOW' ? 'show' : 'hide';
        $change_to = $value['review'] == 'SHOW' ? 'hide' : 'show';
        ?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo ucfirst($value['title']); ?></td>
							<td><?php echo $value['number_questions']; ?> câu</td>
							<td><?php echo $value['etitle']; ?></td>
							<td><?php echo $value['academic_name']; ?></td>
							<td style="text-align: center"><?php
        if ($value['published']) :
            ?> <a href="javascript:void(0);" title="Đang mở"> <img
									src="<?php echo BACK_END_IMAGE_PATH ?>tick_circle.png" />
							</a> <?php else: ?> <a
								href="published/<?php echo $value['topic_manage_id']; ?>"
								title="Đang đóng"> <img
									src="<?php echo BACK_END_IMAGE_PATH ?>cross_circle.png" />
							</a> <?php endif; ?>
							</td>
							<td class="<?php echo $tdStyle; ?>"><span
								id="<?php echo $value['topic_manage_id']; ?>"
								data-review="<?php echo $change_to; ?>" class="tdReview"><?php echo $review; ?></span>
							</td>
							<td style="text-align: center">
								<?php echo anchor(BACK_END_TMPL_PATH . 'topic/export/' . $id, "<img src=\"" . BACK_END_IMAGE_PATH . "rar.png\" />"); ?>
							</td>
							<td style="text-align: center"><img class="showListStudentAnswer"
								id="<?php echo $value['topic_manage_id']; ?>"
								src="<?php echo BACK_END_IMAGE_PATH; ?>rar.png" /></td>
							<td><?php echo setDate($value['created_time'], 'notime'); ?></td>
							<td><img src="<?php echo BACK_END_IMAGE_PATH ?>trash.png"
								alt="Trash" title="Trash" class="imgDelete"
								id="<?php echo $value['topic_manage_id']; ?>" /></td>
						</tr>
						<?php endforeach; ?>
					</tbody>

				</table>

			</div>
			<!-- End #tab1 -->
			<a href="#messages" rel="modal" id="virtualLink"></a>
			<div id="messages" style="display: none">
				<!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->
				<div></div>
			</div>
			<a href="#files" rel="modal" id="virtualfiles"></a>
			<div id="files" style="display: none">
				<!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->
				<div></div>
			</div>
		</div>
		<!-- End .content-box-content -->

		<!-- </div>  End .content-box -->
		<?php echo form_close(); ?>
<script src="<?php echo BACK_END_JS_PATH; ?>topic/lists.js"></script>