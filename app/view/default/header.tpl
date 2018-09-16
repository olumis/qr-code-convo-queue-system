<!doctype html>
<html lang="<?= $_SESSION['language'] ?>">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?= lang('meta_desc') ?>">
	<meta name="author" content="<?= lang('meta_author') ?>">

	<title><?= sprintf('%s / %s', $title, lang('sitename_title')) ?></title>

	<link rel="shortcut icon" href="<?= u(TEMPLATE.'/olumis/img/favicon.ico') ?>" type="image/x-icon">
	<link rel="icon" href="<?= u(TEMPLATE.'/olumis/img/favicon.ico') ?>" type="image/x-icon">
	<link rel="stylesheet" href="<?= u(TEMPLATE.'/default.css?%s',time()) ?>">
	<?php foreach ($links as $link) : ?>
	<?= $link ?>
	<?php endforeach ?>

</head>
<body>

<div class="container">
	<div class="row">

		<?php if ((isset($_SESSION['error']) && $_SESSION['error']) || (isset($_SESSION['success']) && $_SESSION['success'])) : ?>

			<div class="modal fade sc-notice" tabindex="-1" role="dialog" aria-labelledby="olumis-modal-label" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('close') ?>"><span aria-hidden="true"><i class="fa fa-window-close fa-lg"></i></span></button>
							<h4 class="modal-title" id="olumis-modal-label"><i class="fa fa-info-circle fa-lg"></i> <?= lang('information') ?></h4>
						</div>
						<div class="modal-body">
							<?php if (isset($_SESSION['error']) && $_SESSION['error']) : ?>
								<?php foreach ($_SESSION['error'] as $msg) : ?>
									<div><i class="fa fa-fire"></i> <?= $msg ?></div>
								<?php endforeach ?>
							<?php elseif (isset($_SESSION['success']) && $_SESSION['success']) : ?>
								<?php foreach ($_SESSION['success'] as $msg) : ?>
									<div><i class="fa fa-fire"></i> <?= $msg ?></div>
								<?php endforeach ?>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>

		<?php endif ?>

		<div class="modal fade js-notice" tabindex="-1" role="dialog" aria-labelledby="olumis-modal-label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="<?= lang('close') ?>"><span aria-hidden="true"><i class="fa fa-window-close fa-lg"></i></span></button>
						<h4 class="modal-title" id="olumis-modal-label"><i class="fa fa-info-circle fa-lg"></i> <?= lang('information') ?></h4>
					</div>
					<div class="modal-body">
						<div class="th-notice"></div>
					</div>
				</div>
			</div>
		</div>

		<header>

			<div style="padding: 0px 0 10px 15px">
				<i class="fa fa-mortar-board fa-4x"></i> <h2 style="margin: 0 !important; padding: 0 !important; font-weight: bold !important;"><?= lang('sitename') ?></h2>
				<small><?= lang('short_lorem') ?></small>
			</div>

			<?php if (is_logged() && (isset($_SESSION['user']['fullname']) && $_SESSION['user']['fullname'])) : ?>
				<nav class="navbar navbar-default" style="margin-bottom: 0 !important;">
			<?php else: ?>
				<nav class="navbar navbar-default">
			<?php endif ?>
			
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span><?= lang('menu') ?></span>
					</button>
					
					<a class="navbar-brand" href="/"><i class="fa fa-home fa-lg"></i></a>
				</div>
				
				<?php if (!is_logged()) : ?>
				
						<div class="collapse navbar-collapse">
							<ul class="nav navbar-nav">
								<li class="<?= $root == 'login'      ? 'active' :'' ?>"><a href="<?= u('/login') ?>"><i class="fa fa-user"></i> <?= lang('login') ?></a></li>
								<li class="<?= $root == 'register'   ? 'active' :'' ?>"><a href="<?= u('/register') ?>"><i class="fa fa-user-plus"></i> <?= lang('register') ?></a></li>
							</ul>
						</div>
				
				<?php else: ?>
				
					<?php if (in_array($acl['superadmin'], $_SESSION['acl'])): ?>
					
						<div class="collapse navbar-collapse">
							<ul class="nav navbar-nav">
								<li class="<?= $root == 'admin'      ? 'active' :'' ?>"><a href="<?= u('/admin') ?>"><i class="fa fa-cog"></i> <?= lang('member_area') ?></a></li>
								<li class="<?= $root == 'superadmin' ? 'active' :'' ?>"><a href="<?= u('/superadmin') ?>"><i class="fa fa-cogs"></i> <?= lang('admin_area') ?></a></li>
								<li><a href="<?= u('/logout') ?>"><i class="fa fa-sign-out"></i> <?= lang('logout') ?></a></li>
							</ul>
						</div>
						
					<?php elseif (in_array($acl['admin'], $_SESSION['acl']) || in_array($acl['icp'], $_SESSION['acl'])) : ?>
						
						<div class="collapse navbar-collapse">
							<ul class="nav navbar-nav">
								<li class="<?= $root == 'admin'      ? 'active' :'' ?>"><a href="<?= u('/admin') ?>"><i class="fa fa-cog"></i> <?= lang('member_area') ?></a></li>
								<li><a href="<?= u('/logout') ?>"><i class="fa fa-sign-out"></i> <?= lang('logout') ?></a></li>
							</ul>
						</div>
						
					<?php endif ?>
					
				<?php endif ?>
				
			</nav>
			
		</header>

		<?php if (is_logged() && (isset($_SESSION['user']['fullname']) && $_SESSION['user']['fullname'])) : ?>
			<div class="currently-logged-as">
				<p><?= sprintf(lang('currently_logged_as'),$_SESSION['user']['fullname']) ?></p>
			</div>
		<?php endif ?>

