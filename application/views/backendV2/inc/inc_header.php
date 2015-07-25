<?php 
$user = $this->session->userdata('user');
?>
<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="<?php echo BACKEND_V2_IMAGE_PATH; ?>logo.png" height="35" alt="Elearning Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<form action="pages-search-results.html" class="search nav-form">
						<div class="input-group input-search">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="<?php echo BACKEND_V2_IMAGE_PATH; ?>!logged-user.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="<?php echo BACKEND_V2_IMAGE_PATH; ?>!logged-user.jpg" />
							</figure>
							<div class="profile-info" data-lock-name="<?php echo $user->username; ?>" data-lock-email="<?php echo $user->username; ?>">
								<span class="name"><?php echo $user->username; ?></span>
								<!--  
								<span class="role"><?php echo $user->role; ?></span>
								 -->
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo site_url(BACKEND_V2_TMPL_PATH . 'users/change_password'); ?>"><i class="fa fa-user"></i> Thay đổi mật khẩu</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo site_url(BACKEND_V2_TMPL_PATH . 'users/logout'); ?>"><i class="fa fa-power-off"></i> Thoát</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->