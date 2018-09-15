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

<div class="col-lg-3 col-md-6">
	<a href="<?= u('/superadmin/attendance') ?>">
		<div class="panel shadow">
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-qrcode fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?= $totalstudents->row['total_rows'] ?></div>
						<div><?= lang('attendance') ?></div>
					</div>
				</div>
			</div>
		</div>
	</a>
</div>

<div class="col-lg-3 col-md-6">
	<a href="<?= u('/superadmin/live-queue') ?>">
		<div class="panel shadow">
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-mortar-board fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?= 0 ?></div>
						<div><?= lang('live_queue') ?></div>
					</div>
				</div>
			</div>
		</div>
	</a>
</div>

<div class="col-lg-3 col-md-6">
	<a href="<?= u('/superadmin/faculty') ?>">
		<div class="panel shadow">
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-university fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?= $totalfaculties->row['total_rows'] ?></div>
						<div><?= lang('faculty') ?></div>
					</div>
				</div>
			</div>
		</div>
	</a>
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


<?= $footer ?>
