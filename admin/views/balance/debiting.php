<?php

use booking\helpers\CurrencyHelper;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/* @var $dataProviderDebiting ActiveDataProvider */
?>

<table class="table table-striped table-adaptive">
<tr>
    <th width="20px">№</th>
    <th width="180px">Дата списания</th>
    <th width="150px">Сумма списания</th>
    <th width="350px">Тип списания</th>
    <th>Ссылка</th>
</tr>
    <?php foreach ($dataProviderDebiting->getModels() as $i => $item): ?>
    <tr>
        <td><?= $i + 1 ?></td>
        <td><?= date('d-M-Y H:i', $item->created_at) ?></td>
        <td><?= CurrencyHelper::stat($item->amount) ?></td>
        <td><?= $item->nameType() ?></td>
        <td><?= empty($item->link) ? $item->caption : '<a href="'. $item->link . '">'. $item->caption . '</a>' ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="row">
    <div class="col-sm-6 text-left">
        <?= LinkPager::widget([
            'pagination' => $dataProviderDebiting->getPagination(),
        ]) ?>
    </div>
    <div class="col-sm-6 text-right"><?= 'Показано' . ' ' . $dataProviderDebiting->getCount() . ' из ' . $dataProviderDebiting->getTotalCount() ?></div>
</div>

