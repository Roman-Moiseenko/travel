<?php

use booking\entities\moving\Page;
use booking\entities\survey\Survey;
use booking\helpers\StatusHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\moving\SurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Опросы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <p>
        <?= Html::a('Создать Опрос', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'attribute' => 'caption',
                    'value' => function (Survey $model) {
                        return Html::a($model->caption, Url::to(['view', 'id' => $model->id]));
                    },
                    'format' => 'raw',
                    'label' => 'Заголовок',
                    'contentOptions' => ['data-label' => 'Заголовок'],
                ],
                [
                        'attribute' => 'status',
                    'value' => function (Survey $model) {
                        return StatusHelper::statusToHTML($model->status);
                    },
                    'format' => 'raw',
                    'filter' => [StatusHelper::STATUS_INACTIVE => 'Черновик', StatusHelper::STATUS_ACTIVE => 'Активный'],
                    'label' => 'Статус',
                    'contentOptions' => ['data-label' => 'Статус'],
                ],

                ['class' => ActionColumn::class],
            ],
        ]); ?>
    </div>
</div>