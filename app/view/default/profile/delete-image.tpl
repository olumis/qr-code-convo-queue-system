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
            <img class="img-responsive" src="<?= u('/img/profile/').$image['dimension']['thumb'] ?>" alt="">
        </div>
    </div>
</div>

<div class="col-lg-8 col-md-8">
    <div class="panel shadow">
        <div class="panel-body">
            <div class="alert alert-warning"><?= lang('are_you_sure') ?></div>
            <form action="<?= sprintf(u('/').'profile/delete-image?user_image_id=%d', $image['user_image_id']) ?>" method="post" autocomplete="off" class="form-horizontal">				
                <div class="control-group">
                    <button type="submit" name="user_image" class="btn btn-success"><i class="fa fa-check-circle fa-lg"></i> <?= lang('submit') ?></button>
                    <a class="btn btn-default" href="<?= u('/profile') ?>"><i class="fa fa-minus-circle fa-lg"></i> <?= lang('cancel') ?></a>
                </div>
            </form>
        </div>
    </div>			
</div>


<?= $footer ?>
