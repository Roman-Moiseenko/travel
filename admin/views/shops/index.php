<?php


use admin\forms\shops\ShopSearch;
use booking\entities\shops\Shop;
use booking\helpers\shops\ShopTypeHelper;
use booking\helpers\StatusHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel ShopSearch */

$this->title = 'Мои магазины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать Магазин', Url::to('shop/create'), ['class' => 'btn btn-success']) ?>
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
                        'label' => 'Тип',
                        'value' => function (Shop $model) {
                            return $model->isAd() ? '<span class="badge badge-info">Витрина</span>' : '<span class="badge badge-warning">Онлайн</span>';
                        },
                        'format' => 'raw',
                        'filter' => [false => 'Онлайн', true => 'Витрина'],
                        'attribute' => 'ad',
                        'contentOptions' => ['data-label' => 'Тип'],
                    ],
                    [
                        'value' => function (Shop $model) {
                            return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : '';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['data-label' => 'Фото'],
                        'options' => ['width' => '100px'],
                    ],

                    [
                        'label' => 'Название',
                        'value' => function (Shop $model) {
                            return Html::a(Html::encode($model->name), ['/shop/products/' . $model->id]);
                        },
                        'format' => 'raw',
                        'attribute' => 'name',
                        'options' => ['width' => '40%',],
                        'contentOptions' => ['data-label' => 'Название'],
                    ],

                    [
                        'label' => 'Категория',
                        'value' => function (Shop $model) {
                            return ShopTypeHelper::list()[$model->type_id];
                        },
                        'format' => 'raw',
                        'attribute' => 'type_id',
                        'filter' => ShopTypeHelper::list(),
                        'contentOptions' => ['data-label' => 'Категория'],
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'value' => function (Shop $model) {
                            return StatusHelper::statusToHTML($model->status);
                        },
                        'options' => ['width' => '150px'],
                        'format' => 'raw',
                        'filter' => StatusHelper::listStatus(),
                        'contentOptions' => ['data-label' => 'Статус'],
                    ],
                ],
            ]); ?>

        </div>
    </div>
</div>
