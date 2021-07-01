<?php

use booking\entities\forum\Section;
use booking\helpers\SysHelper;
use booking\helpers\UserForumHelper;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $sections Section[] */
$description ='';
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

$this->title = 'Форум для туристов и гостей Калининграда, отзывы, советы для переезжающих, туристов и гостей';
$this->params['breadcrumbs'][] = 'Форум';
$this->params['canonical'] = Url::to(['/forum'], true);
$mobile = SysHelper::isMobile();
?>

<div>
    <h1 <?= $mobile ? 'style="font-size: 22px"' :''?>>Форум для туристов и гостей Калининграда</h1>
    <?php foreach ($sections as $section): ?>
    <div class="card list-cart mt-4">
        <div class="card-header"><h2 style="font-size: 16px;"><?= $section->caption ?></h2></div>
        <div class="card" style="border: 0 !important; border-radius: 7px !important;">
            <table class="table-forum">
                <tbody>
            <?php foreach ($section->categories as $category):?>
             <?= $this->render($mobile ? '_row_category_mobile' : '_row_category', [
                    'category' => $category,
                ]) ?>
            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endforeach; ?>
</div>
