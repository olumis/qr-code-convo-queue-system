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
		
    		<form action="<?= u('/superadmin/faculty/delete?faculty_id=%d', $_GET['faculty_id']) ?>" method="post" autocomplete="off" class="form-horizontal">
    			<div class="form-group clearfix">
        			<label class="col-sm-3 control-label"><?= lang('faculty_name') ?> <span class="text-danger">*</span></label>
        			<div class="col-sm-9">
        				<input type="text" name="name" class="form-control" placeholder="<?= lang('faculty_name') ?>" value="<?= isset($faculty['name']) ? $faculty['name'] : '' ?>">
        			</div>
        		</div>
        		
        		<div class="form-group clearfix">
					<label class="col-sm-3 control-label hidden-xs">&nbsp;</label>
					<div class="col-sm-9">
						<button type="submit" name="delete_faculty" class="btn btn-success"><span class="fa fa-check-circle fa-lg"></span> <?= lang('submit') ?></button>
						<a class="btn btn-default" href="<?= u('/superadmin/faculty') ?>"><i class="fa fa-minus-circle fa-lg"></i> <?= lang('cancel') ?></a>
					</div>
				</div>
    		</form>
		
		</div>
	</div>
</div>

<?= $footer ?>

