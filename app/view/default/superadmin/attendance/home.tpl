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

<div class="col-lg-4" id="camera-container">
    <div class="panel shadow">
		<div class="panel-body">
            <p class="lead text-center">CAMERA</p>
            <hr>
            <video id="camera" class="img-responsive"></video>
        </div>
    </div>
</div>

<div class="col-lg-4" id="confirmed-student-container">
    <div class="panel shadow">
		<div class="panel-body">
            <p class="lead text-center">CONFIRMED STUDENT</p>
            <hr>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?= lang('fullname') ?></th>
                        <th><?= lang('faculty') ?></th>
                        <th><?= lang('id') ?></th>
                    </tr>
                </thead>
                <tbody id="confirmed-student">
                    <?php foreach($students as $student) : ?>
                        <tr>
                            <td><?= $student['fullname'] ?></td>
                            <td><?= $student['faculty'] ?></td>
                            <td><?= $student['student_id'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-lg-4" id="active-student-container">
    <div class="panel shadow">
		<div class="panel-body">
            <p class="lead text-center">ACTIVE STUDENT</p>
            <hr>
            <div id="active-student"></div>
            
            <hr>
            <p class="text-center">
                <input type="button" class="btn btn-primary" value="<?= lang('go') ?>">
            </p>
        </div>
    </div>
</div>

<?= $footer ?>
