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
			<a class="btn btn-primary" href="<?= u('/superadmin/page/add') ?>"><i class="fa fa-file-o fa-lg"></i> <?= lang('new_page') ?></a>
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
							<th><?= lang('page_name') ?></th>
							<th><?= lang('page_seourl') ?></th>
						</tr>
					</thead>
					
					<?php if ($pages->num_rows) : ?>
					
						<?php foreach ($pages->rows as $i => $page ) : ?>
							<tr>
								<td align="right">
									<a href="<?= u('/superadmin/page/edit?page_id=%d', $page['page_id']) ?>" class="btn btn-default" title="<?= lang('edit') ?>"><i class="fa fa-edit fa-2x"></i></a>
									<a href="<?= u('/superadmin/page/delete?page_id=%d', $page['page_id']) ?>" class="btn btn-default" title="<?= lang('delete') ?>"><i class="fa fa-times-circle fa-2x"></i></a>
								</td>
								<td><?= ($i+1) ?></td>
								<td><?= $page['page_name'] ?></td>
								<td><a href="<?= sprintf('%spage/%s',u('/'), $page['page_seourl']) ?>" class="newin"><i class="fa fa-external-link"></i> <?= sprintf('/page/%s',$page['page_seourl']) ?></a></td>
							</tr>
						<?php endforeach ?>
					
					<?php else: ?>
						<tr>
							<td colspan="10"><small><em><?= lang('no_item') ?></em></small></td>
						</tr>
					<?php endif ?>
					
				</table>
			</div>
		</div>
	</div>
</div>

<?= $footer ?>

