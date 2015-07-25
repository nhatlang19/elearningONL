<?php
// get user info
$user = $this->session->userdata('user');

// load sidebar config
$this->config->load('el-sidebar');
$menu = $this->config->item('menu');
?>
<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

	<div class="sidebar-header">
		<div class="sidebar-title">Navigation</div>
		<div class="sidebar-toggle hidden-xs"
			data-toggle-class="sidebar-left-collapsed" data-target="html"
			data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<?php
					foreach ($menu as $key => $item) :
					   $roles = $item['role'];
					   if (in_array($user->role, $roles)) :
					       $hasChild = !empty($item['child']);
					?>
					<li <?php echo $hasChild ? 'class="nav-parent"': ''; ?>>
					<?php if($hasChild): ?>
						<a>
							<i class="<?php echo $item['icon']; ?>" aria-hidden="true"></i> 
        					<span><?php echo $item['title']; ?></span>
    					</a>
					<?php else: ?>
						<a href="<?php echo site_url($item['link']); ?>">
							<i class="<?php echo $item['icon']; ?>" aria-hidden="true"></i> 
        					<span><?php echo $item['title']; ?></span>
    					</a>
					<?php endif; ?> 
						<ul class="nav nav-children">
							<?php foreach($item['child'] as $k => $e) : ?>
								<li class="<?php echo $e['class']; ?>">
									<?php
                                        echo anchor(site_url($e['link']), $e['title']);
                                    ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</li>
					<?php 
					   endif;
					endforeach;
					?>
				</ul>
			</nav>

			<hr class="separator" />
		</div>

	</div>

</aside>
<!-- end: sidebar -->