<?php

use booking\entities\booking\trips\Trip;
use booking\helpers\StatusHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\forms\TripSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои Туры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать Тур', Url::to('trip/common/create'), ['class' => 'btn btn-success']) ?>
    </p>
    <label>Внимание! Для размещения на сайте туров Вы должны быть, либо зарегистрированным туроператором, если размещаете свои туры, либо турагентом, заключившим договор с туроператорам(и)</label>
    <label style="color: red">Раздел находится в разработке</label>

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
                'value' => function (Trip $model) {
                    return $model->mainPhoto ? Html::img($model->mainPhoto->getThumbFileUrl('file', 'admin')) : null;
                },
                'format' => 'raw',
                'options' => ['width' => '100px'],
                'contentOptions' => ['data-label' => 'Фото'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'value' => function (Trip $model) {
                    return StatusHelper::statusToHTML($model->status);
                },
                'options' => ['width' => '150px'],
                'format' => 'raw',
                'filter' => StatusHelper::listStatus(),
                'contentOptions' => ['data-label' => 'Статус'],
            ],
            [
                'attribute' => 'name',
                'value' => function (Trip $model) {
                    return Html::a(Html::encode($model->name), ['/trip/common', 'id' => $model->id]);
                },
                'format' => 'raw',
                'label' => 'Название',
                'options' => ['width' => '25%'],
                'contentOptions' => ['data-label' => 'Название'],
            ],
            [
                'attribute' => 'description',
                'value' => function (Trip $model) {
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
                        $url = Url::to(['/trip/common/index', 'id' => $model->id]);
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
