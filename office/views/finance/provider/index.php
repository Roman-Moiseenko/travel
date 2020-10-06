<?php

/* @var $payments array */

use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Выплаты провайдерам';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="finance-list">
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#ID</th>
                <th>Организация</th>
                <th>ИНН</th>
                <th>Общая сумма платежей</th>
                <th>Сумма к выплате</th>
                <th>Вознаграждение</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?= $payment['legal_id']?></td>
                    <td><?= Html::a($payment['name'], Url::to(['finance/provider/view', 'id' => $payment['legal_id']]))?></td>
                    <td><?= $payment['INN']?></td>
                    <td><?= CurrencyHelper::cost($payment['amount'])?></td>
                    <td><?= CurrencyHelper::cost($payment['pay_legal'])?></td>
                    <td><?= CurrencyHelper::cost($payment['amount'] - $payment['pay_legal'])?></td>
                    <td>
                        <?= Html::a('<i class="fas fa-cash-register"></i>', Url::to(['finance/provider/pay', 'id' => $payment['legal_id']]), ['title' => 'Отметить как выплаченные']) ?>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
