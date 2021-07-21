<?php

use booking\entities\Page;

/* @var $pages Page[] */
?>
<p class="py-2"></p>
<?php foreach ($pages as $page): ?>
    <div class="row py-4">
            <div class="col">
                <?= $this->render('_button_image', [
                    'category' => $page,
                ]) ?>
            </div>
            <div class="col-lg-8 col-md-6">
                <?= $this->render('_button_description', [
                    'category' => $page,
                ]) ?>
            </div>
    </div>
<?php endforeach; ?>
