
		<div id="main-content"> <!-- Main Content Section with everything -->
			<?php echo form_open(BACK_END_TMPL_PATH . 'topic/save', array('name' => "adminForm", 'id' => 'adminForm', 'enctype' => 'multipart/form-data')); ?>	
			<!-- Page Head -->
			<h2>Quản lý kho câu hỏi</h2>
			<ul class="shortcut-buttons-set">								
				
				<li>
				<?php
					$new_page = '<span>
						<img src="' . BACK_END_IMAGE_PATH . 'paper_content_pencil_48.png" alt="icon" /><br />
						Tạo kho mới
					</span>';
					echo anchor(BACK_END_TMPL_PATH . 'storage/edit', $new_page, array('class' => 'shortcut-button')); 
				?>
				</li>
				
			</ul><!-- End .shortcut-buttons-set -->
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					
					<h3>Danh sách kho</h3>
					
					<div class="clear"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
				<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
												
						<table>
							
							<thead>
								<tr>
								   <th align="center">STT</th>	
								   <th><input class="check-all" type="checkbox" /></th>	
								   						   
								   <th>Tiêu đề</th>
								   <th>Thời gian</th>
								   <th style="text-align: center">Số câu hỏi</th>
								   <th>Bộ môn</th>
								   <th>Export</th>
								   <th>Import</th>
								   <th style="text-align: center">Trạng thái</th>
								   <th>Id</th>
								</tr>
								
							</thead>
							<tfoot>
								<tr>
									<td colspan="6">
										<div class="bulk-actions align-left">
											
										</div>
										
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
								foreach($lists as $key => $value) : 
								?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td>
									<input type="checkbox" name="check[]" id="check" value="<?php echo $value->storage_id; ?>" />
									</td>
									<td><?php echo anchor(BACK_END_TMPL_PATH . 'storage/edit/' . $value->storage_id, $value->title); ?></td>
									<td><?php echo setDate($value->updated_time, 'time'); ?></td>
									<td style="text-align: center"><?php echo $value->num_question; ?></td>
									<td><?php echo $value->subjects_name; ?></td>
									<td><?php echo anchor(BACK_END_TMPL_PATH . 'storage/export/' . $value->storage_id, 'Export'); ?></td>
									<td>
										<a id="<?php echo $value->storage_id; ?>" class="btimport" href="#messages" rel="modal">Import</a>
									</td>
									<td style="text-align: center">
									<?php
									if($value->published): 
									?>
										<a href="#" title="Đang mở">
										<img src="<?php echo BACK_END_IMAGE_PATH ?>tick_circle.png" /></a>
									<?php else: ?>
										<a href="#" title="Đang đóng">
										<img src="<?php echo BACK_END_IMAGE_PATH ?>cross_circle.png" /></a>
									<?php endif; ?>
									</td>
									<td><?php echo $value->storage_id; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
							
						</table>
						
					</div> <!-- End #tab1 -->
				
				</div> <!-- End .content-box-content -->
				
			<!-- </div>  End .content-box -->
			<?php echo form_close(); ?>	
<div id="messages" style="display: none"> <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->

	<h4>Import Excel<small>(.xls)</small></h4><p></p>
		<link rel="stylesheet" href="<?php echo BACK_END_CSS_PATH; ?>jquery.fileupload.css">
		<center>
		<span class="btn fileinput-button">
        <span><p>Drag your file to here or click</p><img align="center" src="<?php echo BACK_END_IMAGE_PATH; ?>upload-field-icon.png" /></span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="uploadfile" />
	    </span>
	    </center>
	    <br>Download template from <a href="<?php echo BACK_END_TEMPLATES_PATH; ?>template_import_questions.docx">here</a><br>
	    <br>
	    <!-- The global progress bar -->
	    <div id="progress" class="progress">
	        <div class="progress-bar progress-bar-success"></div>
	    </div>
	    
	    <!-- The container for the uploaded files -->
	    <div id="files" class="files"></div>
	    <br>
		<input class="storage_id" type="hidden" name="storage_id" id="storage_id" value="" />
</div> <!-- End #messages -->
<script src="<?php echo BACK_END_JS_PATH; ?>storage/lists.js"></script>
