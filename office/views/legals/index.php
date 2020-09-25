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
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'options' => ['width' => '20px',]
                        ],
                        [
                            'attribute' => 'INN',
                            'label' => 'ИНН',
                            'options' => ['width' => '150px',]
                        ],
                        [
                            'attribute' => 'name',
                            'value' => function (Legal $model) {
                                return Html::a($model->name, ['legals/view', 'id' => $model->id]);
                            },
                            'label' => 'Название',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'caption',
                            'value' => function (Legal $model) {
                                return Html::a($model->caption, ['legals/view', 'id' => $model->id]);
                            },
                            'label' => 'Заголовок',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'user_id',
                            'value' => function (Legal $model) {
                                return Html::a($model->user->username, ['providers/view', 'id' => $model->user_id]);
                            },
                            'label' => 'Провайдер',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'datetime',
                            'label' => 'Создан',
                        ],
                    ],
                ]); ?>
            </div>
        </div>

</div>
