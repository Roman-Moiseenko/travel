<?php

use booking\entities\admin\Legal;
use booking\entities\mailing\Mailing;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\MailingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рассылка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="legals-list">
    <p>
        <?= Html::a('Новая рассылка', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'attribute' => 'theme',
                        'label' => 'Тема',
                        'value' => function (Mailing $model) {
                            return Html::a(Mailing::nameTheme($model->theme), ['mailing/view', 'id' => $model->id]);
                            },
                        'format' => 'raw',
                        'filter' => Mailing::listTheme(),
                        'contentOptions' => ['data-label' => 'Тема'],
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function (Mailing $model) {
                            return $model->status == Mailing::STATUS_SEND ? '<span class="badge badge-secondary">Отправлена</span>' : '<span class="badge badge-success">Новая</span>';
                        },
                        'label' => 'Рассылка',
                        'format' => 'raw',
                        'contentOptions' => ['data-label' => 'Рассылка'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Создан',
                        'format' => 'date',
                        'contentOptions' => ['data-label' => 'Создан'],
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>
