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
		
    		<form action="<?= u('/superadmin/page/edit?page_id=%d', $_GET['page_id']) ?>" method="post" autocomplete="off" class="form-horizontal">
    			<div class="form-group clearfix">
        			<label class="col-sm-3 control-label"><?= lang('page_name') ?> <span class="text-danger">*</span></label>
        			<div class="col-sm-9">
        				<input type="text" name="page_name" class="form-control" placeholder="<?= lang('page_name') ?>" value="<?= isset($page['page_name']) ? $page['page_name'] : '' ?>">
        			</div>
        		</div>
        		
    			<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('page_content') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<div id="summernote"><?= isset($page['page_content']) ? $page['page_content'] : '' ?></div>
						<textarea name="page_content" class="hidden"><?= isset($page['page_content']) ? $page['page_content'] : '' ?></textarea>
					</div>
				</div>
				
        		<div class="form-group clearfix">
					<label class="col-sm-3 control-label hidden-xs">&nbsp;</label>
					<div class="col-sm-9">
						<button type="submit" name="edit_page" class="btn btn-success"><span class="fa fa-check-circle fa-lg"></span> <?= lang('submit') ?></button>
						<a class="btn btn-default" href="<?= u('/superadmin/page') ?>"><i class="fa fa-minus-circle fa-lg"></i> <?= lang('cancel') ?></a>
					</div>
				</div>
    		</form>
		
		</div>
	</div>
</div>

<?= $footer ?>

