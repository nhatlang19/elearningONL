<!-- start: page -->
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(BACKEND_V2_TMPL_PATH . 'users/edit', ['id' => 'form', 'class' => 'form-horizontal form-bordered', 'autocomplete' => 'off']); ?>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>

				<h2 class="panel-title"><?php echo $title; ?></h2>
			</header>
			<div class="panel-body">
				<?php echo validation_errors('<div class="alert alert-danger">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>', '</div>'); ?>
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Họ tên <span class="required">*</span>
					</label>
					<div class="col-md-6">
						<input type="text" name="fullname" class="form-control"
							id="inputDefault" required
							value="<?php echo isset($userInfo->fullname) ? $userInfo->fullname : ''; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Tên đăng
						nhập <span class="required">*</span>
					</label>
					<div class="col-md-6">
						<input type="text" name="username" class="form-control"
							id="inputDefault" required
							value="<?php echo isset($userInfo->username) ? $userInfo->username : ''; ?>">
					</div>
				</div>
				<?php if(!isset($id)) : ?>
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputPassword">Mật khẩu
						<span class="required">*</span>
					</label>
					<div class="col-md-6">
						<input type="password" name="password" class="form-control"
							id="inputPassword" required
							value="">
					</div>
				</div>
				<?php endif; ?>
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputEmail">Email <span
						class="required">*</span></label>
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon"> <i class="fa fa-envelope"></i>
							</span> <input class="form-control" type="email" required
								placeholder="eg.: email@email.com" name="email"
								value="<?php echo isset($userInfo->email) ? $userInfo->email : ''; ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Chọn bộ môn</label>
					<div class="col-md-6">
						<select data-plugin-selectTwo class="form-control populate"
							name="subjects_id">
								<?php 
								foreach ($subjects as $item) :
								$selected = '';
								if (isset($storage->subjects_id) &&  $item->subjects_id == $userInfo->subjects_id) {
								    $selected = 'selected="selected"';
								}
								?>
									<option <?php echo $selected; ?>
								value="<?php echo $item->subjects_id; ?>"><?php echo $item->subjects_name; ?></option>
								<?php 
								endforeach; 
								?>
							</select>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-sm-9 col-sm-offset-3">
						<button class="btn btn-primary"><?php echo isset($id) ? 'Cập nhật' : 'Tạo mới'; ?></button>
						<button type="reset" class="btn btn-default">Phục hồi</button>
					</div>
				</div>
			</footer>
			<input type='hidden' name='id' id='id'
				value='<?php if(isset($id)) echo $id; ?>' />
		</section>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- Specific Page Vendor -->
<script
	src="<?php echo BACKEND_V2_VENDOR_PATH; ?>jquery-validation/jquery.validate.js"></script>
<!-- Validate form -->
<script src="<?php echo BACKEND_V2_JS_PATH; ?>forms/form.validation.js"></script>