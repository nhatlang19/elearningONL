<div id="sidebar">
	<div id="sidebar-wrapper">
		<!-- Sidebar with logo and menu -->



		<!-- Logo (221px wide) -->
		<h2 style="margin: 10px">
			<a href="#">Admin Panel</a>
		</h2>

		<!-- Sidebar Profile links -->
		<div id="profile-links">
			Hello,
			<?php
			$user = $this->session->userdata('user');

			echo anchor(site_url(BACK_END_TMPL_PATH . 'users/change_password'),
			$user->username, array('title' => 'Change Password'));
			?>. <?php echo anchor(site_url(BACK_END_TMPL_PATH . 'users/logout'), 'Thoát', array('title' => 'Thoát'))?>
		</div>

		<ul id="main-nav">
			<!-- Accordion Menu -->
			
			
				<?php
				$this->config->load('el-sidebar');
				$menu = $this->config->item('menu');
				foreach($menu as $key =>  $item) :
					$roles = explode('|', $item['role']);
					if(in_array($user->role, $roles)) :
				?>
					<li>
						<?php if(count($item['menu']) < 2) :
							$classMenu = $item['menu'][0];
							$array = array('class' => $classMenu['class']);
							echo anchor(BACK_END_TMPL_PATH . $classMenu['link'], $classMenu['title'], $array);
						?>
						<?php else: ?>
							<a href="#" class="nav-top-item <?php echo $key; ?>"> <!-- Add the class "current" to current menu item -->
								<?php echo $item['title']; ?>
							</a>
							<ul id="ul-<?php echo $key; ?>">
								<?php foreach($item['menu'] as $k => $e) : ?>
								<li>
									<?php
										$array = array('class' => $e['class']);
										echo anchor(BACK_END_TMPL_PATH . $e['link'], $e['title'], $array);
									?>
								</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<!-- End #main-nav -->

	</div>
</div>
<!-- End #sidebar -->
<script type="text/javascript">
		<?php
			$controller = $this->uri->segment(2);
			$action = $this->uri->segment(3); 
		?>
		$(document).ready(function() {			
			$('.<?php echo $controller; ?>-<?php echo $action?>').addClass('current');
			$('.<?php echo $controller; ?>').addClass('current');
			$('#ul-<?php echo $controller; ?>').css('display', 'block');
		});
		</script>
