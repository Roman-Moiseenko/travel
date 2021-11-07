<?php

use booking\entities\touristic\fun\Category;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $category Category|null */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a('Редактировать', Url::to(['update-category', 'id' => $category->id]), ['class' => 'btn btn-warning'])?>
    <?= Html::a('Добавить Развлечение', Url::to(['create-fun', 'id' => $category->id]), ['class' => 'btn btn-success'])?>
</p>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <a href="<?= $category->getUploadedFileUrl('photo')?>">
                    <img src="<?= $category->getThumbFileUrl('photo', 'admin')?>" class="img-responsive">
                </a>
            </div>
            <div class="col-sm-8">
                <?= $category->description ?>
            </div>
        </div>
    </div>
</div>

Список развлечений
