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

<div class="col-lg-4">
    <div class="panel shadow">
		<div class="panel-body">
            <p class="lead text-center">CAMERA</p>
            <hr>
            <video id="camera" style="width: 100%;"></video>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="panel shadow">
		<div class="panel-body">
            <p class="lead text-center">CONFIRMED STUDENT</p>
            <hr>
            <div id="confirm-student">
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="panel shadow">
		<div class="panel-body">
            <p class="lead text-center">ACTIVE STUDENT</p>
            <hr>
            <div id="active-student">
            </div>
        </div>
    </div>
</div>

<?= $footer ?>
