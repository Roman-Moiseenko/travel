<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
use booking\helpers\StatusHelper;
use http\Url;
use office\forms\ProviderLegalSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $legal Legal */


$this->title = 'Организация: ' . $legal->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
\yii\web\YiiAsset::register($this);
?>
<div class="legals-view">
    <div class="card">
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $legal,
                'attributes' => [
                    [
                        'label' => 'Наименование',
                        'attribute' => 'name',
                    ],
                    [
                        'label' => 'ИНН',
                        'attribute' => 'INN',
                    ],
                    [
                        'label' => 'КПП',
                        'attribute' => 'KPP',
                    ],
                    [
                        'label' => 'ОГРН',
                        'attribute' => 'OGRN',
                    ],
                    [
                        'label' => 'БИК банка',
                        'attribute' => 'BIK',
                    ],
                    [
                        'label' => 'Р/счет',
                        'attribute' => 'account',
                    ],
                    [
                        'label' => 'Заголовок (торговая марка)',
                        'attribute' => 'caption',
                    ],
                    [
                        'label' => 'Адрес',
                        'attribute' => 'address.address',
                    ],
                    [
                        'label' => 'Офис (помещение, кабинет и пр.)',
                        'attribute' => 'office',
                    ],
                    [
                        'label' => 'Телефон для уведомлений',
                        'attribute' => 'noticePhone',
                    ],
                    [
                        'label' => 'Почта для уведомлений',
                        'attribute' => 'noticeEmail',
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <?php if ($legal->tours): ?>
    <div class="card card-dark">
        <div class="card-header">Туры</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($legal->tours as $tour): ?>
                <tr>
                    <td><?= $tour->id ?></td>
                    <td><a href="<?= \yii\helpers\Url::to(['tours/view', 'id' => $tour->id])?>" ><?= $tour->name ?></a></td>
                    <td><?= StatusHelper::statusToHTML($tour->status) ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($legal->stays): ?>
        <div class="card card-dark">
            <div class="card-header">Жилища</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Наименование</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($legal->stays as $stay): ?>
                        <tr>
                            <td><?= $stay->id ?></td>
                            <td><a href="<?= \yii\helpers\Url::to(['stays/view', 'id' => $stay->id])?>" ><?= $stay->name ?></a></td>
                            <td><?= StatusHelper::statusToHTML($stay->status) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($legal->cars): ?>
        <div class="card card-dark">
            <div class="card-header">Авто</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Наименование</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($legal->cars as $car): ?>
                        <tr>
                            <td><?= $car->id ?></td>
                            <td><a href="<?= \yii\helpers\Url::to(['cars/view', 'id' => $car->id])?>" ><?= $car->name ?></a></td>
                            <td><?= StatusHelper::statusToHTML($car->status) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
