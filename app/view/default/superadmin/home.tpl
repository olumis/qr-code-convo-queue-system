<?= $header ?>

<div class="col-lg-offset-2 col-lg-8">

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
    
    <div class="col-lg-3 col-md-6">
    	<a href="<?= u('/superadmin/member') ?>">
    		<div class="panel shadow">
    			<div class="panel-body">
    				<div class="row">
    					<div class="col-xs-3">
    						<i class="fa fa-users fa-5x"></i>
    					</div>
    					<div class="col-xs-9 text-right">
    						<div class="huge"><?= $totalusers->row['total_rows'] ?></div>
    						<div><?= lang('member') ?></div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</a>
    </div>
    
    <div class="col-lg-3 col-md-6">
    	<a href="<?= u('/superadmin/page') ?>">
    		<div class="panel shadow">
    			<div class="panel-body">
    				<div class="row">
    					<div class="col-xs-3">
    						<i class="fa fa-copy fa-5x"></i>
    					</div>
    					<div class="col-xs-9 text-right">
    						<div class="huge"><?= $totalpages->row['total_rows'] ?></div>
    						<div><?= lang('page') ?></div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</a>
    </div>
</div>

<?= $footer ?>