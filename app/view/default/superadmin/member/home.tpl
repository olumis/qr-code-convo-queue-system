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
		
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>#</th>
							<th><?= lang('fullname') ?></th>
							<th><?= lang('faculty') ?></th>
							<th><?= lang('student_id') ?></th>
							<th><?= lang('is_administrator') ?></th>
						</tr>
					</thead>
					
					<?php if ($members->total_rows) : ?>
					
						<?php foreach ($members->rows as $i => $member ) : ?>
							<tr>
								<td align="right">
									<a href="<?= u('/superadmin/member/edit?user_id=%d', $member['user_id']) ?>" class="btn btn-default" title="<?= lang('edit') ?>"><i class="fa fa-edit fa-2x"></i></a>
									<a href="<?= u('/superadmin/member/delete?user_id=%d', $member['user_id']) ?>" class="btn btn-default" title="<?= lang('delete') ?>"><i class="fa fa-times-circle fa-2x"></i></a>
								</td>
								<td><?= (($page-1)*PAGE_LIMIT)+($i+1) ?></td>
								<td><?= $member['fullname'] ?></td>
								<td><?= $member['faculty'] ?></td>
								<td><?= $member['student_id'] ?></td>
								<td>
									<?php if ($member['is_superadmin']) : ?>
										<span class="label label-success"><?= lang('yes') ?></span>
									<?php else : ?>
										<span class="label label-warning"><?= lang('no') ?></span>
									<?php endif ?>
								</td>
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

