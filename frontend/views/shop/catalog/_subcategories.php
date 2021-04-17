<?php


use booking\entities\shops\products\Category;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $category Category */
?>
<?php if ($category->children):?>
    <div class="card card-default">
        <div class="card-body">
            <?php foreach ($category->children as $child): ?>
                <a href="<?= Html::encode(Url::to(['/shop/catalog/category', 'id' => $child->id])) ?>"><?= Html::encode($child->name) ?></a>&nbsp;|
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
