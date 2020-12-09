<?php

use booking\entities\booking\funs\Fun;
use booking\helpers\BookingHelper;
use booking\helpers\funs\WorkModeHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var  $fun Fun*/


$this->title = 'Параметры ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Параметры';
?>
<div class="funs-view">

    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Основные параметры</div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $fun,
                        'attributes' => [
                            [
                                'label' => 'Ограничение по возрасту',
                                'value' => function (Fun $model) {
                                    return BookingHelper::ageLimit($model->params->ageLimit);
                                },
                                'captionOptions' => ['width' => '30%'],
                            ],
                            [
                                    'label' => 'Аннотация к комментарию бронирования',
                                'attribute' => 'params.annotation',
                            ],

                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Характеристики</div>
                <div class="card-body">
                    <table class="table table-adaptive table-striped table-bordered">
                        <tbody>
                        <?php foreach ($fun->values as $value): ?>
                            <tr>
                                <td data-label="Характеристика"><?= $value->characteristic->name ?></td>
                                <td data-label="Значение"><?= $value->value ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary">
                <div class="card-header with-border">Режим работы</div>
                <div class="card-body">
                    <table class="table table-adaptive table-striped table-bordered adaptive-width-50">
                        <tbody>
                        <?php foreach ($fun->params->workMode as $i => $mode): ?>
                            <tr>
                                <td data-label="Характеристика" width="40px"><?= WorkModeHelper::week($i) ?></td>
                                <td data-label="Значение"><?= WorkModeHelper::mode($mode) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['/fun/params/update', 'id' => $fun->id]) ,['class' => 'btn btn-success']) ?>
    </div>
    

</div>

