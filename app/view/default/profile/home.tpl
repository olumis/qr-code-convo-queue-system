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

<div class="col-lg-4 col-md-8">
	<div class="panel shadow">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-3">
					<i class="fa fa-vcard-o fa-5x"></i>
				</div>
				<div class="col-xs-9 text-right">
					<div class="huge"><?= sprintf('%s %s%d',lang('user_id'),'&#35;', $user['user_id']) ?></div>
				</div>
			</div>
			<div><?= $user['email'] ?></div>
		</div>
	</div>
	
	<div class="panel shadow">
		<div class="panel-body">
			<?php if (isset($user['dimension']) && $user['dimension']) : ?>								
				<div class="thumb">
					<a href="<?= sprintf(u('/').'profile/delete-image?user_image_id=%d', $user['user_image_id']) ?>" class="close">&times;</a>
					<a class="thumbnail" href="<?= u('/img/profile/'.$user['dimension']['large']) ?>"><img class="img-responsive" src="<?= u('/img/profile/'.$user['dimension']['thumb']) ?>" alt=""></a>
				</div>
			<?php else: ?>
				<div class="thumb">
					<img class="img-responsive" src="<?= u('/default/olumis/img/holder.png') ?>" alt="">
				</div>
			<?php endif ?>
		</div>
	</div>
	
	<div class="panel shadow">
		<div class="panel-body">
			<div class="form-group">
				<div><label class="control-label"><?= lang('profile_picture') ?></label></div>
				<button type="button" class="btn btn-info browse"><?= lang('browse') ?></button>
				<input type="file" name="image" id="image">
			</div>
		
			<div class="form-group">
				<div class="progress progress-striped active"></div>
			</div>
		</div>
	</div>
	
</div>

<div class="col-lg-8 col-md-8">
	<div class="panel shadow">
		<div class="panel-body">
			<form action="<?= u('/profile') ?>" method="post" autocomplete="off" class="form-horizontal">
				<div class="row">
    				<hr>
    				<p class="lead"><?= lang('personal_details') ?></p>
    			</div>
    			
    			<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('usertitle') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<select name="usertitle" class="selectpicker show-tick show-menu-arrow">
							<option value=""><?= sprintf(lang('select_s'),lang('usertitle')) ?></option>
							<?php foreach ($usertitles as $usertitle) : ?>
								<option value="<?= $usertitle['name'] ?>" <?= $user['usertitle'] == $usertitle['name'] ? 'selected' :'' ?>><?= $usertitle['name'] ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
    			
    			<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('fullname') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" name="fullname" placeholder="<?= lang('fullname') ?>" class="form-control" value="<?= $user['fullname'] ?>">
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('mobile_no') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" name="mobile_no" placeholder="<?= lang('mobile_no') ?>" class="form-control" title="<?= lang('mobile_no') ?>" data-toggle="popover" data-content="Example:<br>0179553208" value="<?= $user['mobile_no'] ?>">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('faculty') ?> </label>
					<div class="col-sm-9">
						<input type="text" name="faculty" placeholder="<?= lang('faculty') ?>" class="form-control" title="<?= lang('faculty') ?>" value="<?= $user['faculty'] ?>">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('student_id') ?> </label>
					<div class="col-sm-9">
						<input type="text" name="student_id" placeholder="<?= lang('student_id') ?>" class="form-control" title="<?= lang('student_id') ?>" value="<?= $user['student_id'] ?>">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('staff_id') ?> </label>
					<div class="col-sm-9">
						<input type="text" name="staff_id" placeholder="<?= lang('staff_id') ?>" class="form-control" title="<?= lang('staff_id') ?>" value="<?= $user['staff_id'] ?>">
					</div>
				</div>
				
    			<div class="row">
    				<hr>
    				<p class="lead"><?= lang('login_details') ?></p>
    			</div>
    			
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('email') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="email" name="email" placeholder="<?= lang('email') ?>" class="form-control" title="<?= lang('email') ?>" data-toggle="popover" data-content="Example:<br>cwebs@tm.com.my" value="<?= $user['email'] ?>">
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('password') ?></label>
					<div class="col-sm-9">
						<input type="password" name="password" placeholder="<?= lang('password') ?>" class="form-control">
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label hidden-xs">&nbsp;</label>
					<div class="col-sm-9">
						<button type="submit" name="profile" class="btn btn-success"><span class="fa fa-check-circle fa-lg"></span> <?= lang('submit') ?></button>
						<a href="<?= u('/admin') ?>" class="btn btn-default cancel"><span class="fa fa-minus-circle fa-lg"></span> <?= lang('cancel') ?></a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?= $footer ?>