<?php

use booking\entities\realtor\Landowner;
use booking\helpers\StatusHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $searchModel \office\forms\realtor\LandownersSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */


$this->title = 'Землевладения';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="landowner-index">
    <p>
        <?= Html::a('Создать Землевладение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-adaptive table-striped table-bordered',
            ],
            'columns' => [
                [
                    'attribute' => 'name',
                    'label' => 'Землевладения',
                    'value' => function (Landowner $model) {
                        return Html::a($model->name, ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['data-label' => 'Землевладелец'],
                ],
                [
                    'attribute' => 'phone',
                    'label' => 'Телефон',
                    'contentOptions' => ['data-label' => 'Телефон'],
                ],
                [
                    'attribute' => 'slug',
                    'label' => 'Ссылка',
                    'contentOptions' => ['data-label' => 'Ссылка'],
                ],

                [
                    'attribute' => 'status',
                    'filter' => [
                        StatusHelper::STATUS_INACTIVE => 'Черновик',
                        StatusHelper::STATUS_ACTIVE => 'Активен',
                    ],
                    'value' => function (Landowner $model) {
                        return StatusHelper::statusToHTML($model->status);
                    },
                    'format' => 'raw',
                    'label' => 'Статус',
                    'contentOptions' => ['data-label' => 'Статус'],
                ],
                ['class' => ActionColumn::class],
            ],
        ]); ?>
    </div>
</div>


