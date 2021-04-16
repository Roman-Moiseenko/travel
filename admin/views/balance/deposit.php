<?php

use booking\helpers\CurrencyHelper;
use booking\helpers\scr;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/* @var $dataProviderDeposit ActiveDataProvider */
?>

<table class="table table-striped table-adaptive">
<tr>
    <th width="20px">№</th>
    <th width="180px">Дата платежа</th>
    <th width="150px">Сумма платежа</th>
    <th>ID платежа (ЮКасса)</th>
    <th width="120px">Статус</th>
</tr>
    <?php foreach ($dataProviderDeposit->getModels() as $i => $item): ?>
    <tr>
        <td><?= $i + 1 ?></td>
        <td><?= date('d-M-Y H:i', $item->created_at) ?></td>
        <td><?= CurrencyHelper::stat($item->amount) ?></td>
        <td><?= $item->payment_id ?></td>
        <td><?= $item->payment_status ? '<span class="badge badge-success">Подтвержден</span>' : '<span class="badge badge-danger">Не получен</span>' ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="row">
    <div class="col-sm-6 text-left">
        <?php //scr::p($dataProviderDeposit->getPagination());?>
        <?= LinkPager::widget([
            'pagination' => $dataProviderDeposit->getPagination(),
        ]) ?>
    </div>
    <div class="col-sm-6 text-right"><?= 'Показано' . ' ' . $dataProviderDeposit->getCount() . ' из ' . $dataProviderDeposit->getTotalCount() ?></div>
</div>

