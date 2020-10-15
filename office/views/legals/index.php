<?php

use booking\entities\admin\Legal;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\LegalsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="legals-list">

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
                            'attribute' => 'INN',
                            'label' => 'ИНН',
                            'options' => ['width' => '150px',],
                            'contentOptions' => ['data-label' => 'ИНН'],
                        ],
                        [
                            'attribute' => 'name',
                            'value' => function (Legal $model) {
                                return Html::a($model->name, ['legals/view', 'id' => $model->id]);
                            },
                            'label' => 'Название',
                            'format' => 'raw',
                            'contentOptions' => ['data-label' => 'Название'],
                        ],
                        [
                            'attribute' => 'caption',
                            'value' => function (Legal $model) {
                                return Html::a($model->caption, ['legals/view', 'id' => $model->id]);
                            },
                            'label' => 'Заголовок',
                            'format' => 'raw',
                            'contentOptions' => ['data-label' => 'Заголовок'],
                        ],
                        [
                            'attribute' => 'user_id',
                            'value' => function (Legal $model) {
                                return Html::a($model->user->username, ['providers/view', 'id' => $model->user_id]);
                            },
                            'label' => 'Провайдер',
                            'format' => 'raw',
                            'contentOptions' => ['data-label' => 'Провайдер'],
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'datetime',
                            'label' => 'Создан',
                            'contentOptions' => ['data-label' => 'Создан'],
                        ],
                    ],
                ]); ?>
            </div>
        </div>

</div>
