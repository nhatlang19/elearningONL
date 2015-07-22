
<div id="main-content">
	<!-- Main Content Section with everything -->
			<?php echo form_open(BACK_END_TMPL_PATH . 'subject/save', array('name' => "adminForm", 'id' => 'adminForm')); ?>	
			<!-- Page Head -->
	<h2>Quản lý môn học</h2>
	<ul class="shortcut-buttons-set">

		<li>
				<?php
    $new_page = '<span>
						<img src="' . BACK_END_IMAGE_PATH . 'paper_content_pencil_48.png" alt="icon" /><br />
						Tạo mới
					</span>';
    echo anchor(BACK_END_TMPL_PATH . 'subject/edit', $new_page, array(
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

			<h3>Danh sách môn học</h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<!-- This is the target div. id must match the href of this div's tab -->

				<table>

					<thead>
						<tr>
							<th align="center">STT</th>
							<th><input class="check-all" type="checkbox" /></th>

							<th>Tên môn học</th>
							<th>Id</th>
						</tr>

					</thead>
					<tfoot>
						<tr>
							<td colspan="6">
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
        foreach ($lists as $key => $value) :
            ?>
								<tr>
							<td><?php echo $i++; ?></td>
							<td><input type="checkbox" name="check[]" id="check"
								value="<?php echo $value['subjects_id']; ?>" /></td>
							<td><?php echo anchor(BACK_END_TMPL_PATH . 'subject/edit/' . $value['subjects_id'], $value['subjects_name']); ?></td>
							<td><?php echo $value['subjects_id']; ?>
								
						
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
				
			