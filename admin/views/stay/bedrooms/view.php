<?php

use booking\entities\booking\stays\Stay;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  $stay Stay*/


$this->title = 'Спальные места ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилища', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Спальные места';

?>
<div class="bedrooms">
    <div class="card card-info">
        <div class="card-header">Спальные места</div>
        <div class="card-body">
            В жилом помещении имеется <span class="badge badge-primary"><?= count($stay->bedrooms) ?></span> спален<br>
            Максимальное количество гостей <span class="badge badge-primary"><?= $stay->getMaxGuest() ?></span>, за исключением размещаемых на дополнительных кроватей и детей на имеющихся.<br>
            <label>Спальни:</label>
            <?php foreach ($stay->bedrooms as $i => $bedroom): ?>
            <div class="pl-2" style="color: #1e6186;">Спальня <?= $i + 1 ?></div>
            <div class="row">
                <div class="col-sm-11 col-md-10 col-lg-8 col-xl-5 pl-5">
                    <?php foreach ($bedroom->assignBeds as $assignBed): ?>
                    <div class="d-flex">
                        <div><?= $assignBed->typeOfBed->name ?></div>
                        <div class="ml-auto"><?= $assignBed->count?> шт</div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>
