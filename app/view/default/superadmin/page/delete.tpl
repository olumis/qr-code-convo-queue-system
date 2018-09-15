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
		
    		<h1><?= $page['page_name'] ?></h1>
    			
    		<?= $page['page_content'] ?>
		
		</div>
	</div>
</div>

<div class="col-lg-12">
	<div class="panel shadow">
		<div class="panel-body">
    		<form action="<?= u('/superadmin/page/delete?page_id=%d', $_GET['page_id']) ?>" method="post" autocomplete="off" class="form-horizontal">
        		<div class="text-center">
						<button type="submit" name="delete_page" class="btn btn-success"><span class="fa fa-check-circle fa-lg"></span> <?= lang('delete_page') ?></button>
						<a class="btn btn-default" href="<?= u('/superadmin/page') ?>"><i class="fa fa-minus-circle fa-lg"></i> <?= lang('cancel') ?></a>
					</div>
    		</form>
		</div>
	</div>
</div>

<?= $footer ?>

