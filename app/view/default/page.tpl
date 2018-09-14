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
		
			<h1><?= $page['page_name'] ?></h1>
			
			<?= $page['page_content'] ?>
		
		</div>
	</div>
</div>


<?= $footer ?>
