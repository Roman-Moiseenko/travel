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
        <table class="table table-adaptive table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Организация</th>
                <th>ИНН</th>
                <th>Сумма к выплате</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td data-label="ID"><?= $payment['legal_id']?></td>
                    <td data-label="Организация"><?= Html::a($payment['name'], Url::to(['finance/provider/view', 'id' => $payment['legal_id']]))?></td>
                    <td data-label="ИНН"><?= $payment['INN']?></td>
                    <td data-label="Сумма к выплате"><?= CurrencyHelper::cost($payment['amount'])?></td>
                    <td data-label="">
                        <?= Html::a('<i class="fas fa-cash-register"></i>', Url::to(['finance/provider/pay', 'id' => $payment['legal_id']]), ['title' => 'Отметить как выплаченные']) ?>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
