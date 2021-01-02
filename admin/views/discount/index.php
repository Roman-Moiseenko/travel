<?php



use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\entities\booking\cars\Car;
use booking\entities\booking\Discount;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\Stay;
use booking\entities\booking\tours\Tour;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\DiscountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Промо-коды';
$this->params['breadcrumbs'][] = $this->title;
?>
    <p>
        <?= Html::a('Создать Промо-код', Url::to('discount/create'), ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'class' => 'table table-adaptive table-striped table-bordered',

    ],
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
            'options' => ['style' => 'width: 100px'],
            'contentOptions' => ['data-label' => 'Статус'],
        ],
        [
            'attribute' => 'entities',
            'label' => 'Область действий',
            'value' => function (Discount $model) {
                return $model->getCaption();
            },
            'options' => ['width' => '40px'],
            'contentOptions' => ['data-label' => 'Область действий'],
        ],
        [
            'attribute' => 'entities_id',
            'value' => function (Discount $model) {
    //TODO Заглушка Stays идр
                if ($model->entities == Discount::E_ADMIN_USER) return '';
                if ($model->entities_id == null) return 'Все';
                if ($model->entities == Discount::E_USER_LEGAL) {
                    $legal = Legal::findOne($model->entities_id);
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
                if ($model->entities == Discount::E_BOOKING_FUN) {
                    $fun = Fun::findOne($model->entities_id);
                    return $fun->name;
                }
            },
            'format' => 'raw',
            'label' => 'Объект',
            'options' => ['width' => '25%'],
            'contentOptions' => ['data-label' => 'Объект'],
        ],
        [
            'attribute' => 'promo',
            'label' => 'Промо-код',
            'contentOptions' => ['data-label' => 'Промо-код'],
        ],
        [
            'attribute' => 'percent',
            'value' => function (Discount $model) {
                return $model->percent . '%';
            },
            'label' => 'Скидка',
            'contentOptions' => ['data-label' => 'Скидка'],
        ],
        [
            'attribute' => 'count',
            'label' => 'Кол-во применений',
            'value' => function (Discount $model) {
                return $model->count < 0 ? 'Заблокирован' : $model->count;
            },
            'options' => ['width' => '100px'],
            'contentOptions' => ['data-label' => 'Кол-во применений'],
        ],
        [
            'value' => function (Discount $model) {
                if ($model->count < 0) return 'Заблокирован';
                return $model->countNotUsed();
            },
            'label' => 'Остаток',
            'contentOptions' => ['data-label' => 'Остаток'],
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