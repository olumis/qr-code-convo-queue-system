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
			<form action="<?= u('contact') ?>" method="post" autocomplete="off" class="form-horizontal">
			
				<div class="row">
    				<p class="lead"><?= lang('contact_form') ?></p>
    				<hr>
    			</div>

				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('subject') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
					
						<select name="subject" class="selectpicker show-tick show-menu-arrow">
							<option value=""><?= sprintf(lang('select_s'),lang('subject')) ?></option>
							<?php foreach ($subjects as $subject) : ?>
								<option value="<?= $subject['name'] ?>" <?= (isset($posted['subject']) && $posted['subject'] == $subject['name']) ? ' selected': ''; ?>><?= $subject['name'] ?></option>
							<?php endforeach ?>
						</select>
			
					</div>
				</div>
			
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('message') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<textarea name="message" class="form-control min-height-200 pre" placeholder="<?= lang('message') ?>"><?= (isset($posted['message'])) ? $posted['message'] : '' ?></textarea>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('usertitle') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<select name="usertitle" class="selectpicker show-tick show-menu-arrow">
							<option value=""><?= sprintf(lang('select_s'),lang('usertitle')) ?></option>
							
							<?php foreach ($usertitles as $usertitle) : ?>
							
								<?php if (!$posted) : ?>
								
										<?php if ($user['usertitle'] == $usertitle['name']) : ?>
											<option value="<?= $usertitle['name'] ?>" selected><?= $usertitle['name'] ?></option>
										<?php else: ?>
											<option value="<?= $usertitle['name'] ?>"><?= $usertitle['name'] ?></option>
										<?php endif ?>
								
								<?php else: ?>
										
										<?php if ($posted['usertitle'] == $usertitle['name']) : ?>
											<option value="<?= $usertitle['name'] ?>" selected><?= $usertitle['name'] ?></option>
										<?php else: ?>
											<option value="<?= $usertitle['name'] ?>"><?= $usertitle['name'] ?></option>
										<?php endif ?>
										
								<?php endif ?>
								
							<?php endforeach ?>
							
						</select>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('fullname') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<?php if (!$posted) : ?>
							<?php if (!$user['fullname']) : ?>
								<input type="text" name="fullname" id="fullname" class="form-control" placeholder="<?= lang('fullname') ?>">
							<?php else: ?>
								<input type="text" name="fullname" id="fullname" class="form-control" placeholder="<?= lang('fullname') ?>" value="<?= (isset($user['fullname']) && $user['fullname']) ? $user['fullname'] : '' ?>">
							<?php endif ?>
						<?php else: ?>
							<input type="text" name="fullname" id="fullname" class="form-control" placeholder="<?= lang('fullname') ?>" value="<?= (isset($posted['fullname']) && $posted['fullname']) ? $posted['fullname'] : '' ?>">
						<?php endif ?>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('mobile_no') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<?php if (!$posted) : ?>
							<?php if (!$user['mobile_no']) : ?>
								<input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="<?= lang('mobile_no') ?>" data-title="<?= lang('mobile_no') ?>" data-content="<?= lang('po_mobile_no') ?>">
							<?php else: ?>
								<input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="<?= lang('mobile_no') ?>" data-title="<?= lang('mobile_no') ?>" data-content="<?= lang('po_mobile_no') ?>" value="<?= (isset($user['mobile_no']) && $user['mobile_no']) ? $user['mobile_no'] : '' ?>">
							<?php endif ?>
						<?php else: ?>
							<input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="<?= lang('mobile_no') ?>" data-title="<?= lang('mobile_no') ?>" data-content="<?= lang('po_mobile_no') ?>" value="<?= (isset($posted['mobile_no']) && $posted['mobile_no']) ? $posted['mobile_no'] : '' ?>">
						<?php endif ?>
					</div>
				</div>
					
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label"><?= lang('email') ?> <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<?php if (!$posted) : ?>
							<?php if (!$user['email']) : ?>
								<input type="email" name="email" id="email" class="form-control" placeholder="<?= lang('email') ?>" data-title="<?= lang('email') ?>" data-content="<?= lang('po_email') ?>">
							<?php else: ?>
								<input type="email" name="email" id="email" class="form-control" placeholder="<?= lang('email') ?>" data-title="<?= lang('email') ?>" data-content="<?= lang('po_email') ?>" value="<?= (isset($user['email']) && $user['email']) ? $user['email'] : '' ?>">
							<?php endif ?>
						<?php else: ?>
							<input type="email" name="email" id="email" class="form-control" placeholder="<?= lang('email') ?>" data-title="<?= lang('email') ?>" data-content="<?= lang('po_email') ?>" value="<?= (isset($posted['email']) && $posted['email']) ? $posted['email'] : '' ?>">
						<?php endif ?>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-9">
						<button type="submit" name="enquiry" class="btn btn-success"><span class="fa fa-check-circle fa-lg"></span> <?= lang('submit') ?></button>
						<a href="<?= u('/') ?>" class="btn btn-default"><span class="fa fa-minus-circle fa-lg"></span> <?= lang('cancel') ?></a>
					</div>
				</div>
				
			</form>
		
		</div>
	</div>
</div>

<?= $footer ?>
