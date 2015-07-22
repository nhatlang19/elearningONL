
<div id="main-content">
	<!-- Main Content Section with everything -->
			<?php echo form_open(BACK_END_TMPL_PATH . 'students/lists', array('name' => "adminForm", 'id' => 'adminForm')); ?>	
			<!-- Page Head -->
	<h2><?php echo MANAGE_STUDENT; ?></h2>
	<ul class="shortcut-buttons-set">

		<li>
				<?php
    $new_page = '<span>
						<img src="' . BACK_END_IMAGE_PATH . 'paper_content_pencil_48.png" alt="icon" /><br />
						Tạo mới
					</span>';
    echo anchor(BACK_END_TMPL_PATH . 'students/edit', $new_page, array(
        'class' => 'shortcut-button'
    ));
    ?>
				</li>
		<li>
				<?php
    $new_page = '<span>
						<img src="' . BACK_END_IMAGE_PATH . 'paper_content_pencil_48.png" alt="icon" /><br />
						Import
					</span>';
    echo anchor(BACK_END_TMPL_PATH . 'students/import', $new_page, array(
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

			<h3><?php echo LIST_STUDENT;?></h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tab1">
				<!-- This is the target div. id must match the href of this div's tab -->

				<table>

					<thead>
						<tr>
							<td colspan="3">
								<div class="bulk-actions align-left">
									<input class="text-input medium-input " type="text" name="name"
										id="name" placeholder="Họ tên" value="<?php echo $name; ?>" />
								</div>
								<div class="clear"></div>
							</td>
							<td>
								<div class="bulk-actions align-right">
									Chọn lớp: <select name="class_id"
										onchange="adminForm.submit();">
										<option value="-1">__ Tất cả __</option>
												<?php
            
foreach ($classes as $class) :
                $selected = '';
                if ($class_id == $class['class_id']) {
                    $selected = 'selected="selected"';
                }
                ?>
													<option <?php echo $selected; ?>
											value="<?php echo $class['class_id']; ?>"><?php echo $class['class_name']; ?></option>
												<?php endforeach; ?>
											</select>
								</div>
								<div class="clear"></div>
							</td>
						</tr>
						<tr>
							<th>Mã số học sinh</th>
							<th>Tên học sinh</th>
							<th>Tên đăng nhập</th>
							<th>Lớp</th>
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
        foreach ($lists as $key => $value) :
            ?>
								<tr>
							<td><?php echo $value['indentity_number']; ?></td>
							<td><?php echo anchor(BACK_END_TMPL_PATH . 'students/edit/' . $value['student_id'], $value['fullname']); ?></td>
							<td><?php echo $value['username']; ?></td>
							<td><?php echo $value['class_name']; ?>
								
						
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
				
			