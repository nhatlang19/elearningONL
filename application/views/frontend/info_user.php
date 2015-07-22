<?php $student = $this->session->userdata('studentInfo'); ?>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
				data-target=".navbar-responsive-collapse">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Trắc nghiệm kiến thức</a>
		</div>
		<div class="navbar-collapse collapse navbar-responsive-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#" data-toggle="modal" data-target="#myModal"><?php echo $student->fullname; ?></a></li>
				<li><a class="logout" href="#">Thoát</a></li>
			</ul>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Thông tin cá nhân</h4>
      </div>
      <div class="modal-body">
        MSHS: <b><?php echo $student->indentity_number; ?></b><br>
        Họ tên: <b><?php echo $student->fullname; ?></b><br>
        Lớp: <b><?php echo $student->class_name; ?></b><br>
        Đề: <b><?php echo $code; ?></b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tắt</button>
      </div>
    </div>
  </div>
</div>
