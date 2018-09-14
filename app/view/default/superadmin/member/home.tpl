<?= $header ?>

<div class="col-lg-offset-2 col-lg-8">
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

<div class="col-lg-offset-2 col-lg-8">
	<div class="panel shadow">
		<div class="panel-body">
		
			<form action="<?= u('superadmin/member/search') ?>" method="get" autocomplete="off" class="form-horizontal">
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('fullname') ?></label>
					<div class="col-sm-9">
						<input type="text" name="fullname" class="form-control" placeholder="<?= lang('fullname') ?>" value="<?= (isset($_GET['fullname']) && $_GET['fullname']) ? urldecode($_GET['fullname']) : '' ?>">
					</div>
				</div>
							
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('email') ?></label>
					<div class="col-sm-9">
						<input type="text" name="email" class="form-control" placeholder="<?= lang('email') ?>" value="<?= (isset($_GET['email']) && $_GET['email']) ? urldecode($_GET['email']) : '' ?>">
					</div>
				</div>
							
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('mobile_no') ?></label>
					<div class="col-sm-9">
						<input type="text" name="mobile_no" class="form-control" placeholder="<?= lang('mobile_no') ?>" value="<?= (isset($_GET['mobile_no']) && $_GET['mobile_no']) ? urldecode($_GET['mobile_no']) : '' ?>">
					</div>
				</div>
							
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label hidden-xs">&nbsp;</label>
					<div class="col-sm-9">
						<button type="submit" name="search" class="btn btn-default"><i class="fa fa-search fa-lg"></i> <?= lang('search') ?></button>
						<button type="button" class="btn btn-default reset"><i class="fa fa-hourglass-o fa-lg"></i> <?= lang('reset') ?></button>
					</div>
				</div>
						
			</form>
		</div>
	</div>
</div>

<div class="col-lg-offset-2 col-lg-8">
	<div class="panel shadow">
		<div class="panel-body">
		
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>#</th>
							<th><?= lang('fullname') ?></th>
							<th><?= lang('email') ?></th>
							<th><?= lang('mobile_no') ?></th>
						</tr>
					</thead>
					
					<?php if ($members->total_rows) : ?>
					
						<?php foreach ($members->rows as $i => $member ) : ?>
							<tr>
								<td>
									<a href="<?= u('/superadmin/member/edit?user_id=%d', $member['user_id']) ?>" class="btn btn-default" title="<?= lang('edit') ?>"><i class="fa fa-edit fa-2x"></i></a>
									<a href="<?= u('/superadmin/member/delete?user_id=%d', $member['user_id']) ?>" class="btn btn-default" title="<?= lang('delete') ?>"><i class="fa fa-times-circle fa-2x"></i></a>
									<a href="<?= u('/superadmin/member/login?user_id=%d', $member['user_id']) ?>" class="btn btn-default" title="<?= lang('login') ?>"><i class="fa fa-sign-in fa-2x"></i></a>
								</td>
								<td><?= (($page-1)*PAGE_LIMIT)+($i+1) ?></td>
								<td><?= sprintf('%s %s', $member['usertitle'], $member['fullname']) ?></td>
								<td><?= $member['email'] ?></td>
								<td><?= $member['mobile_no'] ?></td>
							</tr>
						<?php endforeach ?>
					
					<?php else: ?>
						<tr>
							<td colspan="10"><small><em><?= lang('no_item') ?></em></small></td>
						</tr>
					<?php endif ?>
					
				</table>
			</div>
				
			<?php if ($pagination) : ?>
					<?= $pagination ?>
			<?php endif ?>
		</div>
	</div>
</div>

<?= $footer ?>

