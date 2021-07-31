<?php

use booking\entities\Page;

/* @var $pages Page[] */
/* @var $section string */
?>
<p class="py-2"></p>
<?php foreach ($pages as $i => $page): ?>
    <div class="row py-4">
        <?php if (($i % 2) == 0): ?>
            <div class="col-lg-4 col-md-6">
                <?= $this->render('_button_image', [
                    'category' => $page,
                    'section' => $section,

                ]) ?>
            </div>
            <div class="col-lg-8 col-md-6">
                <?= $this->render('_button_description', [
                    'category' => $page,
                    'section' => $section,
                ]) ?>
            </div>
        <?php else: ?>
            <div class="col-lg-8 col-md-6">
                <?= $this->render('_button_description', [
                    'category' => $page,
                    'section' => $section,
                ]) ?>
            </div>
            <div class="col-lg-4 col-md-6">
                <?= $this->render('_button_image', [
                    'category' => $page,
                    'section' => $section,
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
