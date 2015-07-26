<script src="<?php echo base_url();?>public/ckeditor/ckeditor.js"
	type="text/javascript"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>public/ckfinder/ckfinder.js"></script>
<div id="main-content">
	<!-- Main Content Section with everything -->


	<!-- Page Head -->
	<h2>Quản lý kho câu hỏi</h2>

	<div class="clear"></div>
	<!-- End .clear -->

	<div class="content-box">
		<!-- Start Content Box -->

		<div class="content-box-header">

			<h3>Edit</h3>

			<div class="clear"></div>

		</div>
		<!-- End .content-box-header -->

		<div class="content-box-content">

			<div class="tab-content" id="tab1">

				<?php echo form_open_multipart(BACKEND_V2_TMPL_PATH . 'storage-question/save'); ?>

					<fieldset>
						
							<?php
    if ($this->session->userdata('error')) :
        ?>
							<span class="input-notification error png_bg red bold">
								<?php
        $error = $this->session->userdata('error');
        $this->session->unset_userdata('error');
        echo $error;
        ?>							
							</span>			
							<?php endif; ?>
						
						<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
					<p>
						<label>Chọn kho</label> <select name="storage" id="storage"
							class="small-input">
								<?php
        
foreach ($storage as $item) :
            $selected = '';
            if ($storage_questions && $item['storage_id'] == $storage_questions['storage_id']) {
                $selected = 'selected="selected"';
            }
            ?>
								<option <?php echo $selected; ?>
								value="<?php echo $item['storage_id']; ?>"><?php echo $item['title']; ?></option>
								<?php endforeach; ?>
							</select>
					</p>
					<p>
						<label id="questionId">Câu hỏi <span id="errorMsgQues"
							class="input-notification error png_bg red bold"
							style="display: none;"> </span>
						</label>
							<?php
    global $config_ckeditor;
    $text = isset($storage_questions['question_name']) ? stripslashes($storage_questions['question_name']) : '';
    echo $this->ckeditor->editor("question_name", $text, $config_ckeditor);
    ?> 							 
								<span class="input-notification png_bg" style="display: none;">Successful
							message</span>
						<!-- Classes for input-notification: success, error, information, attention -->

					</p>
					<p>
						<label>Loại câu hỏi</label> <select name="type" id="type"
							class="small-input">

							<option value="0"
								<?php echo (!@$storage_questions['type'])?'selected="selected"':''?>>Text</option>
							<option value="1"
								<?php echo (@$storage_questions['type'])?'selected="selected"':''?>>Image</option>

						</select>
					</p>
					<label id="answer_sentence">Câu trả lời <span id="errorMsgAns"
						class="input-notification error png_bg red bold"
						style="display: none;"> </span>
					</label> <span class="text"
						<?php echo (@$storage_questions['type'])?'style="display: none;"':''?>>

						<p>
							a. <input class="text-input medium-input answer_name" type="text"
								name="answer_name[]"
								value="<?php if(isset($storage_answer[0]['answer'])) echo stripslashes($storage_answer[0]['answer']); ?>" />
							<input type="checkbox" name="correct_answer"
								<?php if(isset($storage_answer[0]['correct_answer']) && $storage_answer[0]['correct_answer'] == 1) echo 'checked="checked"'; ?>
								class="checkbox-answer" value="0" />
						</p>
						<p>
							b. <input class="text-input medium-input answer_name" type="text"
								name="answer_name[]"
								value="<?php if(isset($storage_answer[1]['answer'])) echo stripslashes($storage_answer[1]['answer']); ?>" />
							<input type="checkbox" name="correct_answer"
								class="checkbox-answer"
								<?php if(isset($storage_answer[1]['correct_answer']) && $storage_answer[1]['correct_answer'] == 1) echo 'checked="checked"'; ?>
								value="1" />
						</p>
						<p>
							c. <input class="text-input medium-input answer_name" type="text"
								name="answer_name[]"
								value="<?php if(isset($storage_answer[2]['answer'])) echo stripslashes($storage_answer[2]['answer']); ?>" />
							<input type="checkbox" name="correct_answer"
								class="checkbox-answer"
								<?php if(isset($storage_answer[2]['correct_answer']) && $storage_answer[2]['correct_answer'] == 1) echo 'checked="checked"'; ?>
								value="2" />
						</p>
						<p>
							d. <input class="text-input medium-input answer_name" type="text"
								name="answer_name[]"
								value="<?php if(isset($storage_answer[3]['answer'])) echo stripslashes($storage_answer[3]['answer']); ?>" />
							<input type="checkbox" name="correct_answer"
								class="checkbox-answer"
								<?php if(isset($storage_answer[3]['correct_answer']) && $storage_answer[3]['correct_answer'] == 1) echo 'checked="checked"'; ?>
								value="3" />
						</p>
					</span> <span class="image"
						<?php echo (!isset($storage_questions['type']) || !$storage_questions['type'])?'style="display: none;"':''?>>

						<p>
							a. <input id="xImagePath0" class="text-input medium-input"
								name="ImagePath[]" type="text" size="60"
								value="<?php if(isset($storage_answer[0]['answer'])) echo $storage_answer[0]['answer']; ?>" />
							<input class="button" type="button" value="Browse Server"
								onclick="BrowseServer( 'Images:/', 'xImagePath0' );" /> <input
								type="checkbox" name="checkbox1" class="checkbox-answer-img"
								<?php if(isset($storage_answer[0]['correct_answer']) && $storage_answer[0]['correct_answer'] == 1) echo 'checked="checked"'; ?>
								value="0" /> 
								<?php if(isset($storage_answer[0]['answer'])) :?>
								
						
						<div>
							<img class="thumb"
								src="<?php echo $storage_answer[0]['answer']; ?>" width="100" />
						</div>
								<?php endif; ?>
								
							</p>
						<p>
							b. <input id="xImagePath1" class="text-input medium-input"
								name="ImagePath[]" type="text" size="60"
								value="<?php if(isset($storage_answer[1]['answer'])) echo $storage_answer[1]['answer']; ?>" />
							<input class="button" type="button" value="Browse Server"
								onclick="BrowseServer( 'Images:/', 'xImagePath1' );" /> <input
								type="checkbox" name="checkbox1" class="checkbox-answer-img"
								<?php if(isset($storage_answer[1]['correct_answer']) && $storage_answer[1]['correct_answer'] == 1) echo 'checked="checked"'; ?>
								value="1" /> 
								<?php if(isset($storage_answer[1]['answer'])) :?>
								
						
						<div>
							<img class="thumb"
								src="<?php echo $storage_answer[1]['answer']; ?>" width="100" />
						</div>
								<?php endif; ?>
							</p>
						<p>
							c. <input id="xImagePath2" class="text-input medium-input"
								name="ImagePath[]" type="text" size="60"
								value="<?php if(isset($storage_answer[2]['answer'])) echo $storage_answer[2]['answer']; ?>" />
							<input class="button" type="button" value="Browse Server"
								onclick="BrowseServer( 'Images:/', 'xImagePath2' );" /> <input
								type="checkbox" name="checkbox1" class="checkbox-answer-img"
								<?php if(isset($storage_answer[2]['correct_answer']) && $storage_answer[2]['correct_answer'] == 1) echo 'checked="checked"'; ?>
								value="2" /> 
								<?php if(isset($storage_answer[2]['answer'])) :?>
								
						
						<div>
							<img class="thumb"
								src="<?php echo $storage_answer[2]['answer']; ?>" width="100" />
						</div>
								<?php endif; ?>
							</p>
						<p>
							d. <input id="xImagePath3" class="text-input medium-input"
								name="ImagePath[]" type="text" size="60"
								value="<?php if(isset($storage_answer[3]['answer'])) echo $storage_answer[3]['answer']; ?>" />
							<input class="button" type="button" value="Browse Server"
								onclick="BrowseServer( 'Images:/', 'xImagePath3' );" /> <input
								type="checkbox" name="checkbox1" class="checkbox-answer-img"
								<?php if(isset($storage_answer[3]['correct_answer']) && $storage_answer[3]['correct_answer'] == 1) echo 'checked="checked"'; ?>
								value="3" /> 
								<?php if(isset($storage_answer[3]['answer'])) :?>
								
						
						<div>
							<img class="thumb"
								src="<?php echo $storage_answer[3]['answer']; ?>" width="100" />
						</div>
								<?php endif; ?>
							</p>
					</span>

					<p>
						<input class="button" id="submit" type="submit" value="Submit" />

						<input class="button" type="button" value="Cancel"
							onclick="goback();" />
					</p>

				</fieldset>

				<div class="clear"></div>
				<!-- End .clear -->
				<input type='hidden' name='id' id='id'
					value='<?php if(isset($id)) echo $id; ?>' /> <input type='hidden'
					name='task' id='task' value='<?php if(isset($task)) echo $task; ?>' />
				<?php echo form_close(); ?>	

			</div>
			<!-- End #tab2 -->
		</div>
		<!-- End .content-box-content -->

		<!-- </div>  End .content-box -->
		<script src="<?php echo BACKEND_V2_JS_PATH; ?>storage_questions/edit.js"></script>