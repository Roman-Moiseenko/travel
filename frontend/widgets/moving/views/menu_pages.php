<?php

use booking\entities\Page;

/* @var $pages Page[] */
?>
<p class="py-2"></p>
<?php foreach ($pages as $i => $page): ?>
    <div class="row py-4">
        <?php if (($i % 2) == 0): ?>
            <div class="col-lg-4 col-md-6">
                <?= $this->render('_button_image', [
                    'category' => $page,
                ]) ?>
            </div>
            <div class="col-lg-8 col-md-6">
                <?= $this->render('_button_description', [
                    'category' => $page,
                ]) ?>
            </div>
        <?php else: ?>
            <div class="col-lg-8 col-md-6">
                <?= $this->render('_button_description', [
                    'category' => $page,
                ]) ?>
            </div>
            <div class="col-lg-4 col-md-6">
                <?= $this->render('_button_image', [
                    'category' => $page,
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
