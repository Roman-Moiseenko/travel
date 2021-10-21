<?php

use booking\entities\moving\agent\Region;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $region Region */
$this->title = 'Регион ' . $region->name;
$this->params['breadcrumbs'][] = ['label' => 'Регионы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $region->name;
?>
<p>
    <?= Html::a('Редактировать', ['update-region', 'id' => $region->id], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Добавить представителя', ['create-agent', 'id' => $region->id], ['class' => 'btn btn-warning']) ?>
</p>
<div class="card card-secondary">
    <div class="card-header">Основные</div>
    <div class="card">
        <?= DetailView::widget([
            'model' => $region,
            'attributes' => [
                [
                    'attribute' => 'name',
                    'label' => 'Название',
                ],
                [
                    'attribute' => 'link',
                    'value' => Html::a($region->link, $region->link),
                    'format' => 'raw',
                    'label' => 'Ссылка',
                ],
            ],
        ]) ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header">Представители</div>
    <div class="card">
        <table class="table table-adaptive table-striped table-bordered">
            <thead>
            <tr>
                <th width="110">Фото</th>
                <th>ФИО</th>
                <th>Описание</th>
                <th width="80">Сортировка</th>
                <th width="80"></th>
            </tr>
            </thead>
            <tbody>
        <?php foreach ($region->agents as $agent): ?>
            <tr>
                <td data-label="Фото"><img class="img-responsive" src="<?= $agent->getThumbFileUrl('photo', 'admin') ?>" /></td>
                <td data-label="ФИО"><a href="<?= Url::to(['view-agent', 'id' => $agent->id])?>"><?= $agent->person->getFullname() ?></a></td>
                <td data-label="Описание"><?= $agent->description ?></td>
                <td data-label="Сортировка">
                    <?=
                    Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up-agent', 'id' => $agent->id],
                        ['data-method' => 'post',]) .
                    Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down-agent', 'id' => $agent->id],
                        ['data-method' => 'post',]);
                    ?>
                </td>
                <td>
                    <a href="<?= Url::to(['update-agent', 'id' => $agent->id])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-agent', 'id' => $agent->id], [
                        'data' => [
                            'confirm' => 'Вы уверены что хотите удалить Категорию?',
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
