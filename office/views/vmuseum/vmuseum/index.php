<?php

use booking\entities\booking\cars\Car;
use booking\entities\vmuseum\VMuseum;
use booking\helpers\StatusHelper;
use office\forms\vmuseum\VMuseumSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel VMuseumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Виртуальные музеи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vmuseum-list">
    <p>
        <?= Html::a('Создать В.Музей', Url::to('/vmuseum/vmuseum/create'), ['class' => 'btn btn-success']) ?>
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
                        'options' => ['width' => '20px',],
                        'contentOptions' => ['data-label' => 'ID'],
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function (VMuseum $model) {
                            return Html::a($model->name, ['vmuseum/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Название',
                        'contentOptions' => ['data-label' => 'Название'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'label' => 'Создан',
                        'contentOptions' => ['data-label' => 'Создан'],
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => StatusHelper::listStatus(),
                        'value' => function (VMuseum $model) {
                            return StatusHelper::statusToHTML($model->status);
                        },
                        'format' => 'raw',
                        'label' => 'Статус',
                        'contentOptions' => ['data-label' => 'Статус'],
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>