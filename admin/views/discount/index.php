<?php

$this->title = 'Промо-коды';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\admin\user\User;
use booking\entities\admin\user\UserLegal;
use booking\entities\booking\cars\Car;
use booking\entities\booking\Discount;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
    <p>
        <?= Html::a('Создать Промо-код', Url::to('discount/create'), ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'label' => 'Статус',
            'value' => function (Discount $model) {
                if ($model->countNotUsed() == 0) {
                    return '<span class="badge badge-primary">used</span>';
                }
                if ($model->countNotUsed() <= 0) {
                    return '<span class="badge badge-secondary">draft</span>';
                }
                return '<span class="badge badge-success">new</span>';
            },
            'format' => 'raw',
            'contentOptions' => ['style' => 'width: 100px'],
        ],
        [
            'attribute' => 'entities',
            'label' => 'Область действий',
            'value' => function (Discount $model) {
                return $model->getCaption();
            },
            'options' => ['width' => '40px'],
        ],
        [
            'attribute' => 'entities_id',
            'value' => function (Discount $model) {
                if ($model->entities == Discount::E_ADMIN_USER) return '';
                if ($model->entities_id == null) return 'Все';
                if ($model->entities == Discount::E_USER_LEGAL) {
                    $legal = UserLegal::findOne($model->entities_id);
                    return $legal->caption . ' (' . $legal->name . ')';
                }
                if ($model->entities == Discount::E_BOOKING_TOUR) {
                    $tour = Tour::findOne($model->entities_id);
                    return $tour->name;
                }
                if ($model->entities == Discount::E_BOOKING_STAY) {
                    $stay = Stay::findOne($model->entities_id);
                    return $stay->name;
                }
                if ($model->entities == Discount::E_BOOKING_CAR) {
                    $car = Car::findOne($model->entities_id);
                    return $car->name;
                }
            },
            'format' => 'raw',
            'label' => 'Объект',
            'options' => ['width' => '25%'],
        ],
        [
            'attribute' => 'promo',
            'label' => 'Промо-код'
        ],
        [
            'attribute' => 'percent',
            'value' => function (Discount $model) {
                return $model->percent . '%';
            },
            'label' => 'Скидка'
        ],
        [
            'attribute' => 'count',
            'label' => 'Кол-во применений',
            'value' => function (Discount $model) {
                return $model->count < 0 ? 'Заблокирован' : $model->count;
            },
            'options' => ['width' => '100px'],
        ],
        [
            'value' => function (Discount $model) {
                if ($model->count < 0) return 'Заблокирован';
                return $model->countNotUsed();
            },
            'label' => 'Остаток'
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    $url = Url::to(['/discount/draft', 'id' => $model->id]);
                    $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                    return Html::a($icon, $url, [
                        'title' => 'Заблокировать',
                        'aria-label' => 'Заблокировать',
                        'data-pjax' => 0,
                        'data-confirm' => 'Вы уверены, что хотите заблокировать Промо-код ' . $model->promo . '?',
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>