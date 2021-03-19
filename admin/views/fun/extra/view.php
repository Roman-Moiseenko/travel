<?php

use booking\entities\booking\funs\Extra;
use booking\entities\booking\funs\Fun;
use booking\helpers\CurrencyHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  $fun Fun */
/* @var $searchModel admin\forms\funs\ExtraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '.extra-check', function () {
        //alert('t');
        let fun_id = $(this).attr('fun-id');
        let extra_id = $(this).attr('extra-id');
        let value = 0;
         if ($(this).is(':checked')) {value = 1;} else {value = 0;}
        $.post("/fun/extra/setextra?fun_id="+fun_id+"&extra_id="+extra_id+"&set="+value,
            {fun_id: fun_id, extra_id: extra_id, set: value},
            function (data) {
        });
    });
});
JS;

$this->registerJs($js);
$this->title = 'Дополнительные услуги ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Дополнительные услуги';
?>
<div class="funs-extra-view">
    <div class="form-group">
        <?= Html::a('Создать услугу', Url::to(['/fun/extra/create', 'id' => $fun->id]), ['class' => 'btn btn-success']) ?>
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
                                'value' => function (Extra $model) use ($fun) {
                                    $checked = $fun->isExtra($model->id) ? 'checked' : '';
                                    return '<input type="checkbox" class="extra-check" fun-id="' .
                                        $fun->id . '" extra-id="' . $model->id . '" ' . $checked . '>';
                                },
                                'format' => 'raw',
                                'filter' => [1 => 'Да', 0 => 'Нет'],
                                'options' => ['width' => '20px'],
                                'contentOptions' => ['data-label' => 'Применить'],
                            ],
                            [
                                'attribute' => 'name',
                                'value' => function (Extra $model) use ($fun) {
                                    return Html::a(Html::encode($model->name), Url::to(['/fun/extra/update', 'id' => $fun->id, 'extra_id' => $model->id]));
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
                                    'update' => function ($url, $model, $key) use ($fun) {
                                        $url = Url::to(['/fun/extra/update', 'id' => $fun->id, 'extra_id' => $model->id]);
                                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                                        return Html::a($icon, $url, [
                                            'title' => 'Изменить',
                                            'aria-label' => 'Изменить',
                                            'data-pjax' => 0,
                                        ]   );
                                    },
                                    'delete' => function ($url, $model, $key) use ($fun) {
                                        $url = Url::to(['/fun/extra/delete', 'id' => $fun->id, 'extra_id' => $model->id]);
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
<?php if ($fun->filling) {
    echo Html::a('Далее >>', Url::to(['filling', 'id' => $fun->id]), ['class' => 'btn btn-primary']);
}

