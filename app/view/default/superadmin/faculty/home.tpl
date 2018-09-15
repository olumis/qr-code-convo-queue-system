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
	<div class="clearfix">		
		<div class="pull-right">
			<a class="btn btn-primary" href="<?= u('/superadmin/faculty/add') ?>"><i class="fa fa-university fa-lg"></i> <?= lang('new_faculty') ?></a>
		</div>
	</div>
	<br>
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
							<th><?= lang('faculty') ?></th>
						</tr>
					</thead>
					
					<tbody>
						<?php if ($faculties->num_rows) : ?>
							
							<?php foreach ($faculties->rows as $i => $faculty ) : ?>
								<tr>
									<td align="right">
										<a href="<?= u('/superadmin/faculty/edit?faculty_id=%d', $faculty['faculty_id']) ?>" class="btn btn-default" title="<?= lang('edit') ?>"><i class="fa fa-edit fa-2x"></i></a>
										<a href="<?= u('/superadmin/faculty/delete?faculty_id=%d', $faculty['faculty_id']) ?>" class="btn btn-default" title="<?= lang('delete') ?>"><i class="fa fa-times-circle fa-2x"></i></a>
									</td>
									<td><?= ($i+1) ?></td>
									<td><?= $faculty['name'] ?></td>
								</tr>
							<?php endforeach ?>
						
						<?php else: ?>
							<tr>
								<td colspan="10"><small><em><?= lang('no_item') ?></em></small></td>
							</tr>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?= $footer ?>

