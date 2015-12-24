<?php
    $error = '';
    if (($error = $this->session->flashdata('error'))) {
        $this->session->set_flashdata('error', null);
    }
    
    $success = '';
    if (($success = $this->session->flashdata('success'))) {
        $this->session->set_flashdata('success', null);
    }
?>
<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(BACKEND_V2_TMPL_PATH . 'users/save', ['id' => 'form', 'class' => 'form-horizontal form-bordered', 'autocomplete' => 'off']); ?>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="fa fa-caret-down"></a>
				</div>

				<h2 class="panel-title">Thay đổi mật khẩu</h2>
			</header>
			<div class="panel-body">
				<?php if(!empty($error)) : ?>
				<div class="alert alert-danger">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                        <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <?php if(!empty($success)) : ?>
				<div class="alert alert-success">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                        <?php echo $success; ?>
                        <br clear='all' />
                        <meta http-equiv="refresh"
							content="5; URL=<?php echo site_url(BACKEND_V2_TMPL_PATH . 'dashboard'); ?>">
						Vui lòng chờ trong 5 giây. Click vào <?php echo anchor(site_url(BACKEND_V2_TMPL_PATH . 'dashboard'), 'đây')?> để không phải chờ lâu
                </div>
                <?php endif; ?>
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Mật khẩu mới <span class="required">*</span>
					</label>
					<div class="col-md-6">
						<input type="text" name="pass" class="form-control"
							id="inputDefault" required
							value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="inputDefault">Xác nhận mật khẩu <span class="required">*</span>
					</label>
					<div class="col-md-6">
						<input type="text" name="re-pass" class="form-control"
							id="inputDefault" required
							value="">
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-sm-9 col-sm-offset-3">
						<button class="btn btn-primary">Cập nhật</button>
						<button type="reset" class="btn btn-default">Phục hồi</button>
					</div>
				</div>
			</footer>
		</section>
		<?php echo form_close(); ?>
	</div>
</div>