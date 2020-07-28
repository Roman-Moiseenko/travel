<?php

use booking\entities\booking\tours\Extra;
use booking\entities\booking\tours\Tours;
use booking\entities\Lang;
use booking\forms\booking\tours\ToursCommonForms;
use booking\helpers\CurrencyHelper;
use booking\helpers\ToursHelper;
use booking\helpers\ToursTypeHelper;
use kartik\widgets\FileInput;
//use mihaildev\ckeditor\CKEditor;
use shop\helpers\PriceHelper;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $tours Tours */
/* @var $searchModel admin\forms\tours\ExtraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дополнительные услуги ' . $tours->name;
$this->params['id'] = $tours->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tours-extra-view">
    <div class="form-group">
        <?= Html::a('Создать услугу', Url::to(['/tours/extra/create', 'id' => $tours->id]), ['class' => 'btn btn-success']) ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Дополнительные услуги</div>
                <div class="card-body">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'label' => '',
                                'value' => function (Extra $model) use ($tours) {
                                    $checked = $tours->isExtra($model->id) ? 'checked' : '';
                                    return '<input type="checkbox" class="extra-check" tours-id="' .
                                        $tours->id . '" extra-id="' . $model->id . '" ' . $checked . '>';
                                },
                                'format' => 'raw',
                                'filter' => [1 => 'Да', 0 => 'Нет'],
                                'options' => ['width' => '20px'],
                            ],
                            [
                                'attribute' => 'name',
                                'value' => function (Extra $model) use ($tours) {
                                    return Html::a(Html::encode($model->name), ['/tours/extra/update', ['id' => $tours->id, 'extra_id' => $model->id]]);
                                },
                                'format' => 'raw',
                                'label' => 'Название',
                                'options' => ['width' => '30%'],
                            ],
                            [
                                'attribute' => 'description',
                                'format' => 'ntext',
                                'label' => 'Описание'
                            ],
                            [
                                'attribute' => 'cost',
                                'label' => 'Цена',
                                'value' => function (Extra $model) {
                                    return CurrencyHelper::get($model->cost);
                                },
                                'options' => ['width' => '60px'],
                            ],
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function ($url, $model, $key) use ($tours) {
                                        $url = Url::to(['/tours/extra/update', 'id' => $tours->id, 'extra_id' => $model->id]);
                                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]);
                                        return Html::a($icon, $url);
                                    },
                                    'delete' => function ($url, $model, $key) use ($tours) {
                                        $url = Url::to(['/tours/extra/delete', 'id' => $tours->id, 'extra_id' => $model->id]);
                                        $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-trash"]);
                                        return Html::a($icon, $url);
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

