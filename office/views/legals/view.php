<?php

use booking\entities\admin\User;
use booking\entities\admin\Legal;
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
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <tbody>
                <?php foreach ($legal->tours as $tour): ?>
                <tr>
                    <td><?= $tour->id ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
