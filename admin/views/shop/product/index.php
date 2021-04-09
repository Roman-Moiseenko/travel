<?php


use admin\forms\shops\ProductSearch;
use booking\entities\shops\products\Category;
use booking\entities\shops\products\Product;
use booking\entities\shops\Shop;
use booking\helpers\shops\CategoryHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $shop Shop */

$this->title = 'Товары';
$this->params['id'] = $shop->id;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['/shop/view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать Товар', Url::to(['create', 'id' => $shop->id]), ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'main_photo_id',
                'label' => '',
                'value' => function (Product $model) {
                    return $model->mainPhoto->getThumbFileUrl('file', 'admin');
                },
                'format' => 'raw',
                'contentOptions' => ['data-label' => 'Фото'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Product $model) {
                    return Html::a(Html::encode($model->name), ['/shop/product/view', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Название'],
            ],
            [
                    'attribute' => 'category_id',
                'label' => 'Категория',
                'value' => function (Product $model) {
                    return $model->category->name;
                },
                'filter' => CategoryHelper::list(),
                'contentOptions' => ['data-label' => 'Категория'],

            ],
            [
                'attribute' => 'active',
                'label' => 'Статус',
                'value' => function (Product $model) {
                    return $model->active ? 'Активный' : 'Черновик';
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'filter' => [false => 'Черновик', true => 'Активный'],
                'contentOptions' => ['data-label' => 'Статус'],
            ],

            [
                'attribute' => 'description',
                'value' => function (Product $model) {
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
                        $url = Url::to(['/shop/product/view', 'id' => $model->id]);
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
