<?= $header ?>

<div class="container content">

	<div class="row">
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
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<h2><i class="fa fa-globe"></i> <?= lang('delete_image') ?></h2>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			
			<div class="alert alert-warning">
				<p><?= lang('are_you_sure') ?></p>
			</div>
			
			<form action="<?= sprintf(u('/').'superadmin/member/delete-image?t=%s&user_id=%d&user_image_id=%d', $_SESSION['token'], $image['user_id'], $image['user_image_id']) ?>" method="post" autocomplete="off" class="form-horizontal">
				<fieldset>
				
					<div class="control-group">
						<label class="col-sm-3 control-label"><?= lang('image') ?></label>
						<div class="col-sm-9">
							<img class="thumbnail" src="<?= u('main/img/profile/').$image['dimension']['thumb'] ?>" alt="">
						</div>
						<div class="clearfix"></div>
					</div>
										
					<div class="control-group">
						<label class="col-sm-3 control-label hidden-xs">&nbsp;</label>
						<div class="col-sm-9">
							<button type="submit" name="user_image" class="btn btn-success"><i class="fa fa-check-circle fa-lg"></i> <?= lang('submit') ?></button>
							<a class="btn btn-default" href="<?= sprintf(u('/').'superadmin/member/edit?t=%s&user_id=%d',$_SESSION['token'], $image['user_id']) ?>"><i class="fa fa-minus-circle fa-lg"></i> <?= lang('cancel') ?></a>
						</div>
						<div class="clearfix"></div>	
					</div>
					
				</fieldset>
				
				<?= nonce() ?>
				
			</form>
			
		</div>
	</div>
</div>

<?= $footer ?>
