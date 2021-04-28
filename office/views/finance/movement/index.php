<?php

use booking\entities\admin\Legal;
use booking\entities\finance\Movement;
use booking\entities\user\User;
use booking\helpers\BookingHelper;
use booking\helpers\CurrencyHelper;
use booking\helpers\scr;
use office\forms\finance\MovementSearch;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel MovementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Платежи клиентов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-list">
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
                        'attribute' => 'user_id',
                        'value' => function (Movement $model) {
                            return $model->user->personal->fullname->getFullname();
                        },
                        'format' => 'raw',
                        'label' => 'Клиент',
                        'filter' => ArrayHelper::map(
                                User::find()->all(),
                                function (User $user) {
                                    return $user->id;
                                },
                                function (User $user) {
                                    return $user->personal->fullname->getShortname() . ' (' . $user->username . ')';
                                }),
                        'contentOptions' => ['data-label' => 'Клиент'],
                    ],
                          [
                              'attribute' => 'object_class',
                              'value' => function (Movement $model) {

                                  $class = $model->object_class;
                                  $object = $class::find()->andWhere(['id' => $model->object_id])->one();
                                  return $object->getName();
                              },
                              'label' => 'Объект Платежа',
                              'contentOptions' => ['data-label' => 'Объект Платежа'],
                          ],
                            [
                                'attribute' => 'legal_id',
                                'value' => function (Movement $model) {
                                        return $model->legal->name;
                                    },
                                'filter' => ArrayHelper::map(Legal::find()->asArray()->all(), 'id', 'name'),
                                'label' => 'Организация',
                                'contentOptions' => ['data-label' => 'Организация'],
                            ],
                            [
                                'attribute' => 'amount',
                                'value' => function (Movement $model) {
                                    return CurrencyHelper::cost($model->amount);
                                },
                                'label' => 'Сумма Платежа',
                                'contentOptions' => ['data-label' => 'Сумма Платежа'],
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function (Movement $model) {
                                    return date('d-m-Y H:i', $model->created_at);
                                },
                                'format' => 'raw',
                                'label' => 'Дата платежа',
                                'contentOptions' => ['data-label' => 'Дата платежа'],
                            ],
                    [
                        'attribute' => 'paid',
                        'value' => function (Movement $model) {
                            return $model->paid ? '<span class="badge badge-success">поступил</span>' : '<span class="badge badge-warning">в ожидании</span>';
                        },
                        'format' => 'raw',
                        'label' => 'Платеж',
                        'contentOptions' => ['data-label' => 'Дата платежа'],

                    ],
                            [
                                'attribute' => 'payment_id',
                                'label' => 'ID платежа',
                                'contentOptions' => ['data-label' => 'ID платежа'],
                            ],
                ],
            ]); ?>
        </div>
    </div>
</div>
