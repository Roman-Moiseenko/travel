<?php

use booking\entities\booking\funs\Type;
use booking\helpers\funs\CharacteristicHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $type Type */


$this->title = 'Категория Развлечения: ' . $type->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории Развлечений', 'url' => Url::to(['guides/fun-type/index'])];
$this->params['breadcrumbs'][] = $type->name;
?>
<div class="fun-type">
    <p>
        <?= Html::a('Создать Характеристику', Url::to(['add-characteristic', 'id' => $type->id]), ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card card-default">
        <div class="card-header">Характеристики</div>
        <div class="card-body">
            <table width="100%" class="table table-adaptive table-striped table-bordered">
                <thead>
                <tr>
                    <th width="20px">ID</th>
                    <th width="20%">Название</th>
                    <th>Тип</th>
                    <th>Значение по умолчанию</th>
                    <th>Обязательное поле</th>
                    <th width="40%">Варианты</th>
                    <th width="20px"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($type->characteristics as $characteristic): ?>
                    <tr>
                        <td data-label="ID"> <?= $characteristic->id ?> </td>
                        <td data-label="Название"> <?= Html::a($characteristic->name, Url::to(['update-characteristic', 'id' => $characteristic->id])) ?> </td>
                        <td data-label="Тип"> <?= CharacteristicHelper::typeName($characteristic->type_variable) ?> </td>
                        <td data-label="Значение по умолчанию" align="center"> <?= $characteristic->default ? $characteristic->default : '-' ?> </td>
                        <td data-label="Обязательное поле" align="center"> <?= $characteristic->required ? '<span class="badge badge-success">Да</span>' : '<span class="badge badge-secondary">Нет</span>' ?> </td>
                        <td data-label="Варианты"> <?= implode(', ', $characteristic->variants) ?> </td>
                        <td>
                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-characteristic', 'id' => $characteristic->id], [
                                'data' => [
                                    'confirm' => 'Вы уверены что хотите удалить Характеристику?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
