
<div id="main-content">
	<!-- Main Content Section with everything -->

	<!-- Page Head -->
	<h2>Quản lý kho câu hỏi</h2>

	<ul class="shortcut-buttons-set">

		<li>
				<?php
    $new_page = '<span>
						<img src="' . BACKEND_V2_IMAGE_PATH . 'paper_content_pencil_48.png" alt="icon" /><br />
						Tạo câu hỏi mới
					</span>';
    echo anchor(BACKEND_V2_TMPL_PATH . 'storage-question/edit', $new_page, array(
        'class' => 'shortcut-button'
    ));
    ?>
				</li>

	</ul>
	<!-- End .shortcut-buttons-set -->

	<div class="clear"></div>
	<!-- End .clear -->

	<div class="content-box">
		<!-- Start Content Box -->

		<div class="content-box-header">

			<h3>Danh sách câu hỏi</h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->

		<div class="content-box-content">
				<?php echo form_open(BACKEND_V2_TMPL_PATH . 'storage_question/lists', array('name' => "adminForm", 'id' => 'adminForm')); ?>	
					<div class="tab-content default-tab" id="tab1">
				<!-- This is the target div. id must match the href of this div's tab -->

				<table>

					<thead>
						<tr>
							<th>STT</th>
							<th><input class="check-all" type="checkbox" /></th>

							<th>Câu hỏi</th>
							<th>Tên kho</th>
							<th>Thời gian tạo</th>
							<th style="text-align: center;">Trạng thái</th>
							<th></th>
						</tr>

					</thead>

					<tfoot>
						<tr>
							<td colspan="5">
								<div class="bulk-actions align-left">
									<select name="dropdown">
										<option value="-1">Choose an action...</option>
										<option value="0">Publish</option>
										<option value="1">Unpublish</option>
									</select> <a class="button" href="javascript:void(0);"
										onclick="adminForm.submit();">Apply to selected</a>
								</div>

								<div class="pagination">
											<?php echo $pagination->create_links(); ?>
										</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
								<?php
        
$i = 1;
        foreach ($storage_questions as $key => $value) {
            ?>
								<tr>
							<td><?php echo $i++; ?></td>
							<td><input type="checkbox" name="check[]" id="check"
								value="<?php echo $value['storage_question_id']; ?>" /></td>
							<td>
								<div class="ellipsis">
									<a id="<?php echo $value['storage_question_id']; ?>"
										class="btimport" href="#messages" rel="modal">
											<?php echo word_limiter(satinateTitle($value['question_name']), 4) . ' ...'; ?></a>
								</div>
							</td>
							<td><?php echo $value['title']; ?></td>
							<td><?php echo setDate($value['updated_time'], 'notime'); ?></td>
							<td style="text-align: center;">
									<?php
            $src = '';
            $published = 0;
            $alt = '';
            if (! $value['published']) {
                $src = BACKEND_V2_IMAGE_PATH . 'cross_circle.png';
                $alt = 'published';
            } else {
                $src = BACKEND_V2_IMAGE_PATH . 'tick_circle.png';
                $alt = 'unpublished';
            }
            $img = "<img src='$src' alt='$alt' />";
            echo anchor(BACKEND_V2_TMPL_PATH . 'storage-question/' . $alt . '/' . $value['storage_question_id'], $img, array(
                'title' => $alt
            ));
            ?>
									</td>
							<td>
								<!-- Icons -->
										<?php echo anchor(BACKEND_V2_TMPL_PATH . 'storage-question/edit/' . $value['storage_question_id'],  '<img src="' . BACKEND_V2_IMAGE_PATH . 'pencil.png" alt="Edit" />', array('title'=>'Edit')); ?>
										<?php echo anchor(BACKEND_V2_TMPL_PATH . 'storage-question/delete/' . $value['storage_question_id'],  '<img src="' . BACKEND_V2_IMAGE_PATH . 'cross.png" alt="Delete" />', array('title'=>'Delete', 'class' => 'btdelete')); ?>									 
									</td>
						</tr>								
								<?php } ?>
							</tbody>

				</table>

			</div>
			<!-- End #tab1 -->
				<?php echo form_close(); ?>	
				</div>
		<!-- End .content-box-content -->

		<!-- </div>  End .content-box -->

		<div id="messages" style="display: none">
			<!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->
			<div></div>
		</div>
		<script
			src="<?php echo BACKEND_V2_JS_PATH; ?>storage_questions/lists.js"></script>