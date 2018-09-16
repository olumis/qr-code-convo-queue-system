<?= $header ?>

<div class="col-lg-12">
	<ol class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) : ?>
			<?php if (!$breadcrumb['is_active']) : ?>
				<li><a href="<?= $breadcrumb['href'] ?>"><?= $breadcrumb['text'] ?></a></li>
			<?php else: ?>
				<li class="active"><?= $breadcrumb['text'] ?></li>
			<?php endif ?>
		<?php endforeach ?>
	</ol>
</div>

<div class="col-lg-4">
		<div class="panel shadow">
			<div class="panel-body">
				
				<h5><?= lang('qr_code') ?></h5>
				<p class="alert alert-info"><?= lang('qr_code_save') ?></p>
				<img src="<?= u('/qrcode-png') ?>" alt="" class="img-responsive qr-code">
				<p class="alert alert-warning"><?= lang('qr_code_pass') ?></p>

			</div>
		</div>
    </div>
    
    <div class="col-lg-4">
		<div class="panel shadow">
			<div class="panel-body">
				<h5>PROFILE</h5>
				
				<?php if (!$user['dimension']['thumb']) : ?>
					<p class="text-center"><i class="fa fa-user-circle-o" style="font-size: 10em;"></i></p>
				<?php else: ?>
					<p class="text-center"><img src="<?= u('/img/profile/%s', $user['dimension']['thumb']) ?>" alt="" style="border-radius: 50%;"></p>
				<?php endif ?>
				
				<ul class="list-group">
					<li class="list-group-item"><?= lang('fullname') ?><br><?= $user['fullname'] ?></li>
					<li class="list-group-item"><?= lang('email') ?><br><?= $user['email'] ?></li>
					<li class="list-group-item"><?= lang('faculty') ?><br><?= ucfirst($user['faculty']) ?></li>
					<li class="list-group-item"><?= lang('student_id') ?><br><?= ucfirst($user['student_id']) ?></li>
				</ul>
			</div>
		</div>
	</div>
    
    <div class="col-lg-4">
    	<a href="<?= u('/profile') ?>">
    		<div class="panel shadow">
    			<div class="panel-body">
    				<div class="row">
    					<div class="col-xs-3">
    						<i class="fa fa-user fa-5x"></i>
    					</div>
    					<div class="col-xs-9 text-right">
    						<div class="huge">&nbsp;</div>
    						<div><?= lang('edit_profile') ?></div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</a>
    	
    	<a href="<?= u('/logout') ?>">
    		<div class="panel shadow">
    			<div class="panel-body">
    				<div class="row">
    					<div class="col-xs-3">
    						<i class="fa fa-sign-out fa-5x"></i>
    					</div>
    					<div class="col-xs-9 text-right">
    						<div class="huge"><div class="huge">&nbsp;</div></div>
    						<div><?= lang('logout') ?></div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</a>
    </div>

<?= $footer ?>
