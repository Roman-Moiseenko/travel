<?php


use booking\entities\blog\Tag;
use office\forms\blog\TagSearch;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Создать Тег', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-adaptive table-striped table-bordered',

                ],
                'columns' => [
                    [
                        'attribute' => 'id',
                        'label' => '',
                        'contentOptions' => ['data-label' => 'ID'],
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function (Tag $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Тег',
                        'contentOptions' => ['data-label' => 'Тег'],
                    ],
                    [
                        'attribute' => 'slug',
                        'label' => 'Ссылка',
                        'contentOptions' => ['data-label' => 'Ссылка'],
                    ],
                    ['class' => ActionColumn::class],
                ],
            ]); ?>
        </div>
    </div>
</div>
