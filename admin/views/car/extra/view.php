<?php

use booking\entities\booking\cars\Car;
use booking\entities\booking\cars\Extra;
use booking\helpers\CurrencyHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  $car Car */
/* @var $searchModel admin\forms\cars\ExtraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '.extra-check', function () {
        let car_id = $(this).attr('car-id');
        let extra_id = $(this).attr('extra-id');
        let value = 0;
         if ($(this).is(':checked')) {value = 1;} else {value = 0;}
        $.post("/car/extra/setextra?car_id="+car_id+"&extra_id="+extra_id+"&set="+value,
            {car_id: car_id, extra_id: extra_id, set: value},
            function (data) {
        });
    });
});
JS;

$this->registerJs($js);

$this->title = 'Дополнительные услуги ' . $car->name;
$this->params['id'] = $car->id;
$this->params['breadcrumbs'][] = ['label' => 'Авто', 'url' => ['/cars']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['/car/common', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Дополнительные услуги';
?>
<div class="cars-extra-view">
    <div class="form-group">
        <?= Html::a('Создать услугу', Url::to(['/car/extra/create', 'id' => $car->id]), ['class' => 'btn btn-success']) ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Дополнительные услуги</div>
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'tableOptions' => [
                            'class' => 'table table-adaptive table-striped table-bordered',

                        ],
                        'columns' => [
                            [
                                'label' => '',
                                'value' => function (Extra $model) use ($car) {
                                    $checked = $car->isExtra($model->id) ? 'checked' : '';
                                    return '<input type="checkbox" class="extra-check" car-id="' .
                                        $car->id . '" extra-id="' . $model->id . '" ' . $checked . '>';
                                },
                                'format' => 'raw',
                                'filter' => [1 => 'Да', 0 => 'Нет'],
                                'options' => ['width' => '20px'],
                                'contentOptions' => ['data-label' => 'Применить'],
                            ],
                            [
                                'attribute' => 'name',
                                'value' => function (Extra $model) use ($car) {
                                    return Html::a(Html::encode($model->name), Url::to(['/car/extra/update', 'id' => $car->id, 'extra_id' => $model->id]));
                                },
                                'format' => 'raw',
                                'label' => 'Название',
                                'options' => ['width' => '20%'],
                                'contentOptions' => ['data-label' => 'Название'],
                            ],
                            [
                                'attribute' => 'name_en',
                                'label' => 'Название (En)',
                                'options' => ['width' => '20%'],
                                'contentOptions' => ['data-label' => 'Название (En)'],
                            ],
                            [
                                'attribute' => 'description',
                                'format' => 'ntext',
                                'label' => 'Описание',
                                'contentOptions' => ['data-label' => 'Описание'],
                            ],
                            [
                                'attribute' => 'description_en',
                                'format' => 'ntext',
                                'label' => 'Описание',
                                'contentOptions' => ['data-label' => 'Описание (En)'],
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
                                    'update' => function ($url, $model, $key) use ($car) {
                                        $url = Url::to(['/car/extra/update', 'id' => $car->id, 'extra_id' => $model->id]);
                                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                                        return Html::a($icon, $url, [
                                            'title' => 'Изменить',
                                            'aria-label' => 'Изменить',
                                            'data-pjax' => 0,
                                        ]   );
                                    },
                                    'delete' => function ($url, $model, $key) use ($car) {
                                        $url = Url::to(['/car/extra/delete', 'id' => $car->id, 'extra_id' => $model->id]);
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

<?php if ($car->filling) {
    echo Html::a('Далее >>', Url::to(['filling', 'id' => $car->id]), ['class' => 'btn btn-primary']);
}