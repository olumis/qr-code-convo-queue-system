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

<div class="col-lg-8">
    <div class="panel shadow">
		<div class="panel-body">
            <p class="lead text-center">CONFIRMED STUDENT</p>
            <hr>
            <div class="table-responsive" id="confirmed-student-container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?= lang('queue_no') ?></th>
                            <th><?= lang('fullname') ?></th>
                            <th><?= lang('faculty') ?></th>
                            <th><?= lang('id') ?></th>
                        </tr>
                    </thead>
                    <tbody id="confirmed-student">
                        <?php if ($students) : ?>
                            <?php foreach($students as $student) : ?>
                                <tr data-user-id="<?= $student['user_id'] ?>">
                                    <td><?= $student['queue_no'] ?></td>
                                    <td><?= $student['fullname'] ?></td>
                                    <td><?= $student['faculty'] ?></td>
                                    <td><?= $student['student_id'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else :?>
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

<div class="col-lg-4" id="active-student-container">
    <div class="panel shadow">
		<div class="panel-body">
            <p class="lead text-center">ACTIVE STUDENT</p>
            <hr>

            <div id="active-student">
                <ul class="list-group">
                    <li class="list-group-item text-center"><span id="profile-pic"><img src="/default/olumis/img/holder.png" style="border-radius: 50%;"></span></li>
					<li class="list-group-item text-center"><span id="fullname"><?= lang('student_name') ?></span></li>
					<li class="list-group-item text-center"><span id="faculty"><?= lang('faculty') ?></span></li>
				</ul>
            </div>
            
            <hr>
            <p class="text-center">
                <input type="button" id="go" class="btn btn-success" value="<?= lang('go') ?>">
                <input type="button" id="reset" class="btn btn-warning" value="<?= lang('reset') ?>">
            </p>
        </div>
    </div>
</div>

<?= $footer ?>
