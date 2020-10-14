<?php

use booking\entities\booking\tours\Extra;
use booking\entities\booking\tours\Tour;
use booking\helpers\CurrencyHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  $tour Tour */
/* @var $searchModel admin\forms\tours\ExtraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дополнительные услуги ' . $tour->name;
$this->params['id'] = $tour->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = ['label' => $tour->name, 'url' => ['/tour/common', 'id' => $tour->id]];
$this->params['breadcrumbs'][] = 'Дополнительные услуги';
?>
<div class="tours-extra-view">
    <div class="form-group">
        <?= Html::a('Создать услугу', Url::to(['/tour/extra/create', 'id' => $tour->id]), ['class' => 'btn btn-success']) ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Дополнительные услуги</div>
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => [
                            'class' => 'table table-adaptive table-striped table-bordered',

                        ],
                        'columns' => [
                            [
                                'label' => '',
                                'value' => function (Extra $model) use ($tour) {
                                    $checked = $tour->isExtra($model->id) ? 'checked' : '';
                                    return '<input type="checkbox" class="extra-check" tours-id="' .
                                        $tour->id . '" extra-id="' . $model->id . '" ' . $checked . '>';
                                },
                                'format' => 'raw',
                                'filter' => [1 => 'Да', 0 => 'Нет'],
                                'options' => ['width' => '20px'],
                                'contentOptions' => ['data-label' => 'Применить'],
                            ],
                            [
                                'attribute' => 'name',
                                'value' => function (Extra $model) use ($tour) {
                                    return Html::a(Html::encode($model->name), ['/tour/extra/update', ['id' => $tour->id, 'extra_id' => $model->id]]);
                                },
                                'format' => 'raw',
                                'label' => 'Название',
                                'options' => ['width' => '30%'],
                                'contentOptions' => ['data-label' => 'Название'],
                            ],
                            [
                                'attribute' => 'description',
                                'format' => 'ntext',
                                'label' => 'Описание',
                                'contentOptions' => ['data-label' => 'Описание'],
                            ],
                            [
                                'attribute' => 'cost',
                                'label' => 'Цена',
                                'value' => function (Extra $model) {
                                    return CurrencyHelper::cost($model->cost);
                                },
                                'options' => ['width' => '60px'],
                                'contentOptions' => ['data-label' => 'Цена'],
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function ($url, $model, $key) use ($tour) {
                                        $url = Url::to(['/tour/extra/update', 'id' => $tour->id, 'extra_id' => $model->id]);
                                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                                        return Html::a($icon, $url, [
                                            'title' => 'Изменить',
                                            'aria-label' => 'Изменить',
                                            'data-pjax' => 0,
                                        ]   );
                                    },
                                    'delete' => function ($url, $model, $key) use ($tour) {
                                        $url = Url::to(['/tour/extra/delete', 'id' => $tour->id, 'extra_id' => $model->id]);
                                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                                        return Html::a($icon, $url, [
                                        'title' => 'Удалить',
                                        'aria-label' => 'Удалить',
                                        'data-pjax' => 0,
                                        'data-confirm' => 'Вы уверены, что хотите удалить Дополнение ' . $model->name . '?',
                                        'data-method' => 'post',
                                    ]);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

