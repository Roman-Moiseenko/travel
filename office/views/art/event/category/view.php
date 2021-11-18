<?php


use booking\entities\art\event\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;


/* @var $this \yii\web\View */
/* @var $category Category */


$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории Событий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a('Редактировать', Url::to(['update', 'id' => $category->id]), ['class' => 'btn btn-warning']) ?>

</p>

<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $category,
            'attributes' => [
                [
                    'attribute' => 'id',
                    'label' => 'ID',
                ],
                [
                    'attribute' => 'name',
                    'label' => 'Название',
                ],
                [
                    'attribute' => 'slug',
                    'label' => 'Ссылка',
                ],
                [
                    'attribute' => 'icon',
                    'label' => 'Иконка',
                ],
            ],
        ]) ?>
    </div>
</div>

<div class="card card-secondary">
    <div class="card-header">SEO</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $category->meta,
            'attributes' => [
                [
                    'attribute' => 'title',
                    'label' => 'Заголовок',
                ],
                [
                    'attribute' => 'description',
                    'label' => 'Описание',
                ],
            ],
        ]) ?>
    </div>
</div>
