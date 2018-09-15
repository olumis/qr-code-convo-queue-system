	
	<div class="clearfix"></div>

	<footer class="footer-bs">
		<div class="row">
			<div class="col-md-3 footer-brand">
				<h3><i class="fa fa-home"></i> <?= lang('sitename') ?></h3>
				<p lang="ms-MY"><?= lang('slogan') ?></p>
				<p><?= sprintf('%s %d %s', '&copy;', date('Y'), lang('sitename')) ?></p>
				<p>
					<a href="/" class="newin"><i class="fa fa-facebook-square fa-2x"></i></a>
					<a href="/" class="newin"><i class="fa fa-twitter-square fa-2x"></i></a>
					<a href="/" class="newin"><i class="fa fa-instagram fa-2x"></i></a>
					<a href="/" class="newin"><i class="fa fa-google-plus-square fa-2x"></i></a>
				</p>
			</div>
			<div class="col-md-4 footer-nav">
				<div class="col-md-6">
					<ul class="list">
						<li><a href="<?= u('/') ?>"><?= lang('home') ?></a></li>
						<li><a href="<?= u('/page/about-us') ?>"><?= lang('about_us') ?></a></li>
						<li><a href="<?= u('/contact') ?>"><?= lang('contact') ?></a></li>
						<li><a href="<?= u('/page/terms-and-condition') ?>"><?= lang('terms_condition') ?></a></li>
						<li><a href="<?= u('/page/privacy-policy') ?>"><?= lang('privacy_policy') ?></a></li>
					</ul>
				</div>
			</div>
			
		</div>
	</footer>
</div><!-- end .row -->
</div><!-- end .container -->

<script src="<?= u(TEMPLATE.'/olumis/js/autobahn.min.js') ?>"></script>
<script src="<?= u(TEMPLATE.'/jquery/jquery.min.js') ?>"></script>
<script src="<?= u(TEMPLATE.'/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= u(TEMPLATE.'/bootstrap-select/js/bootstrap-select.min.js') ?>"></script>
<script src="<?= u(TEMPLATE.'/bootstrap-notify/js/bootstrap-notify.min.js') ?>"></script>
<script src="<?= u(TEMPLATE.'/instascan/js/instascan.min.js?') ?>"></script>
<script src="<?= u('/js/config') ?>"></script>
<script src="<?= u(TEMPLATE.'/default.js?'.time()) ?>"></script>
<?php foreach ($scripts as $script) : ?>
<script src="<?= sprintf('%s?%s', $script, time()) ?>"></script>
<?php endforeach ?>

</body>
</html>
