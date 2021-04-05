<?php


use booking\entities\shops\BaseShop;
use booking\helpers\shops\ShopTypeHelper;
use booking\helpers\StatusHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои магазины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать Магазин (Онлайн)', Url::to('shop/create'), ['class' => 'btn btn-success']) ?>
        <?= Html::a('Создать Витрину (Реклама)', Url::to('shop-ad/create'), ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-adaptive table-striped table-bordered',
        ],
        'columns' => [
            [
                'attribute' => 'id',
                'label' => '#ID',
                'options' => ['width' => '20px', 'style' => 'text-align: center;'],
                'contentOptions' => ['data-label' => 'ID'],
            ],
            [
                'value' => function (BaseShop $model) {
                    if ($model->isAd())
                        return 'Витрина';
                    return 'Онлайн';
                },
                'label' => 'Тип',
                'contentOptions' => ['data-label' => 'Тип'],
            ],
            [
                    'attribute' => 'type_id',
                'label' => 'Категория',
                'value' => function (BaseShop $model) {
                    return ShopTypeHelper::list()[$model->type_id];
                },
                'filter' => $searchModel->typeList(),
                'contentOptions' => ['data-label' => 'Категория'],

            ],
            [
                'value' => function (BaseShop $model) {
                    if ($model->isAd())
                        return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                    return '';
                },
                'format' => 'raw',
                'options' => ['width' => '100px'],
                'contentOptions' => ['data-label' => 'Фото'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'value' => function (BaseShop $model) {
                    return StatusHelper::statusToHTML($model->status);
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'filter' => ShopTypeHelper::list(),
                'contentOptions' => ['data-label' => 'Статус'],
            ],
            [
                'attribute' => 'name',
                'value' => function (BaseShop $model) {
                    return Html::a(Html::encode($model->name), ['/tour/common', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Название'],
            ],
            [
                'attribute' => 'description',
                'value' => function (BaseShop $model) {
                    return StringHelper::truncateWords(strip_tags($model->description), 40);

                },
                'format' => 'ntext',
                'label' => 'Описание',
                'contentOptions' => ['data-label' => 'Описание'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $url = Url::to(['/shop/index', 'id' => $model->id]);
                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]);
                        return Html::a($icon, $url, [
                            'title' => 'Просмотр',
                            'aria-label' => 'Просмотр',
                            'data-pjax' => 0,
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
