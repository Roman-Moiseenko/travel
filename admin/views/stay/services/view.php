<?php

use booking\entities\booking\stays\CustomServices;
use booking\entities\booking\stays\Stay;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $stay Stay */

$this->title = 'Услуги ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Услуги';
?>

<div class="services-stay">
    <div class="card card-info">
        <div class="card-header">Услуги</div>
        <div class="card-body">
            <?php foreach ($stay->services as $customService): ?>
                <div>
                    Услуга <span class="badge badge-warning"><?= $customService->name?>
                    </span> в размере <span class="badge badge-info"><?= $customService->value . ' ' . CustomServices::listPayment()[$customService->payment]?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>