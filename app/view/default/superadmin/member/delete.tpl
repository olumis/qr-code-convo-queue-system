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

<div class="col-lg-12">
	<div class="panel shadow">
		<div class="panel-body">
		
			<div class="alert alert-warning">
				<p><?= lang('are_you_sure') ?></p>
			</div>
						
			<form action="<?= u('/superadmin/member/delete?user_id=%d', $member['user_id']) ?>" method="post" autocomplete="off" class="form-horizontal">
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('user_id') ?></label>
					<div class="col-sm-9">
						<div class="form-control"><?= $member['user_id'] ?></div>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('email') ?></label>
					<div class="col-sm-9">
						<div class="form-control"><?= $member['email'] ?></div>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('fullname') ?></label>
					<div class="col-sm-9">
						<div class="form-control"><?= $member['fullname'] ?></div>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('faculty') ?></label>
					<div class="col-sm-9">
						<div class="form-control"><?= $member['faculty'] ?></div>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('student_id') ?></label>
					<div class="col-sm-9">
						<div class="form-control"><?= $member['student_id'] ?></div>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label hidden-xs">&nbsp;</label>
					<div class="col-sm-9">
						<button type="submit" name="member" class="btn btn-success"><span class="fa fa-check-circle fa-lg"></span> <?= lang('submit') ?></button>
						<a href="<?= u('/superadmin/member') ?>" class="btn btn-default"><span class="fa fa-minus-circle fa-lg"></span> <?= lang('cancel') ?></a>
					</div>
				</div>
				<input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">
			</form>
		</div>
	</div>
</div>

<?= $footer ?>
