<?php

use booking\entities\Page;

/* @var $pages Page[] */
?>

<?php foreach ($pages as $i => $page): ?>
    <div class="row py-4">
        <?php if (($i % 2) == 0): ?>
            <div class="col-sm-4">
                <?= $this->render('_button_image', [
                    'category' => $page,
                ]) ?>
            </div>
            <div class="col-sm-8">
                <?= $this->render('_button_description', [
                    'category' => $page,
                ]) ?>
            </div>
        <?php else: ?>
            <div class="col-sm-8">
                <?= $this->render('_button_description', [
                    'category' => $page,
                ]) ?>
            </div>
            <div class="col-sm-4">
                <?= $this->render('_button_image', [
                    'category' => $page,
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
