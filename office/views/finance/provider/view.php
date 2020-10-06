<?php

use booking\entities\admin\Legal;
use booking\entities\finance\Payment;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $legal Legal */
/* @var $payments Payment[] */
/* @var $deduction integer */

$this->title = 'Провайдер ' . $legal->name;
$this->params['breadcrumbs'][] = ['label' => 'Выплаты провайдерам', 'url' => Url::to(['finance/provider'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-list">
    <p>
        <?= Html::a('<i class="fas fa-cash-register"></i> Отметить как выплаченные', Url::to(['finance/provider/pay', 'id' => $legal->id]), ['class' => 'btn btn-warning']); ?>

    </p>
    <div class="card card-info">
        <div class="card-header">Реквизиты для выплаты</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $legal,
                'attributes' => [
                    [
                        'label' => 'Наименование',
                        'value' => Html::a($legal->name, Url::to(['providers/view', 'id' => $legal->id])),
                        'format' => 'raw',
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
                ],
            ]) ?>
        </div>
    </div>
    <div class="card card-info">
        <div class="card-header">Список бронирования</div>
        <div class="card-body">
            <table width="100%">
                <tr>
                    <th>ID</th>
                    <th>CLASS</th>
                    <th>Дата бронирования</th>
                    <th>Дата исполнения</th>
                    <th>Наименование объекта бронирования</th>
                    <th>Сумма платежа</th>
                </tr>
            <?php foreach ($payments as $payment): ?>
            <tr>
                <td> <?= $payment->booking_id ?> </td>
                <td> <?= $payment->class_booking ?> </td>
                <td> <?= date('d-m-Y', $payment->booking->getCreated()) ?> </td>
                <td> <?= date('d-m-Y', $payment->booking->getDate()) ?> </td>
                <td> <?= Html::a($payment->booking->getName(), $payment->booking->getLinks()['entities']) ?> </td>
                <td> <?= CurrencyHelper::cost($payment->amount) ?> </td>
            </tr>
            <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
