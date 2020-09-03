<?php

$this->title = 'Промо-коды';
$this->params['breadcrumbs'][] = $this->title;

use booking\entities\admin\user\User;
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

<?= \booking\services\booking\DiscountService::generatePromo(User::class) ?>
    Добавить скидку <br>

    Список скидок, сортированные по остатку или дате создания <br>
    if draft() => secondary<br>
    if Остаток == 0 => info(или primary)<br>
    Сущность --- Название Сущности --- Промо-код --- %% --- Кол-во  --- Остаток / draft() /<br>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'label' => 'Статус',
            'value' => '',
            'format' => 'raw',
            'contentOptions' => ['style' => 'width: 100px'],
        ],
        [
            'attribute' => 'entities',
            'label' => 'Область действий',
            'value' => function (\booking\entities\booking\Discount $model) {
                return $model->getCaption();
            },
            'options' => ['width' => '40px'],
        ],
        [
            'attribute' => 'entities_id',
            //'value' => '',
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
            'value' => function (\booking\entities\booking\Discount $model) {
                return $model->percent . '%';
            },
            'label' => 'Скидка'
        ],
        [
            'attribute' => 'count',
            'label' => 'Кол-во применений',
            'options' => ['width' => '100px'],
        ],
        [
            'value' => function (\booking\entities\booking\Discount $model) {
                return $model->countNotUsed();
            },
            'label' => 'Остаток'
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    $url = Url::to(['/discount-draft', 'id' => $model->id]);
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