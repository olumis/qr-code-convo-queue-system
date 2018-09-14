<?= $header ?>

<div class="col-lg-offset-3 col-lg-6">
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
			
<div class="col-lg-offset-3 col-lg-6">
	<div class="panel shadow">
		<div class="panel-body">
			<form action="<?= u('/login') ?>" method="post" autocomplete="off" class="form-horizontal">
				<fieldset>
					<div class="form-group clearfix">
						<label class="col-sm-3 control-label"><?= lang('email') ?> <span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="email" name="email" id="email" placeholder="<?= lang('email') ?>" class="form-control" value="<?= (isset($posted['email'])) ? $posted['email'] : '' ?>" required autofocus>
						</div>
					</div>
					
					<div class="form-group clearfix">
						<label class="col-sm-3 control-label"><?= lang('password') ?> <span class="text-danger">*</span></label>
						<div class="col-sm-9">
							<input type="password" name="password" placeholder="<?= lang('password') ?>" class="form-control">
						</div>
					</div>
					
					<div class="form-group clearfix">
						<label class="col-sm-3 control-label hidden-xs">&nbsp;</label>
						<div class="col-sm-9">
							<button type="submit" name="login" class="btn btn-success"><i class="fa fa-check-circle fa-lg"></i> <?= lang('submit') ?></button>
							<a class="btn btn-default cancel" href="<?= u('/') ?>"><i class="fa fa-minus-circle fa-lg"></i> <?= lang('cancel') ?></a>
						</div>
					</div>
					
					<div class="form-group clearfix">
						<label class="col-sm-3 control-label hidden-xs">&nbsp;</label>
						<div class="col-sm-9">
							<ul class="nav nav-pills">
								<li class=""><a href="<?= u('/register') ?>"><?= lang('register') ?></a></li>
								<li class=""><a href="<?= u('/forgot-password') ?>"><?= lang('forgot_password') ?></a></li>
							</ul>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<?= $footer ?>