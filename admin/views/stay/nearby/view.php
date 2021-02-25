<?php

use booking\entities\booking\stays\nearby\NearbyCategory;
use booking\entities\booking\stays\Stay;
use booking\helpers\scr;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $stay Stay */

$this->title = 'В окрестностях ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'В окрестностях';
?>
<div class="nearby">
    <?php foreach ($stay->getNearbySortCategory() as $group => $category): ?>
        <div class="card card-info">
            <div class="card-header"><?= NearbyCategory::listGroup()[$group] ?></div>
            <div class="card-body">
                <?php foreach ($category as $name_category => $nearby_list): ?>
                <label class="pt-2"><?= $name_category ?>:</label>
                <?php foreach ($nearby_list as $nearby): ?>
                    <div class="pl-2">

                        <?= $nearby['name'] . ' на расстоянии ' . $nearby['distance'] . ' ' .  $nearby['unit']?>
                    </div>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>
