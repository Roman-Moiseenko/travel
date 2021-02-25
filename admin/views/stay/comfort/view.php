<?php


use booking\entities\booking\stays\Stay;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  $stay Stay*/

$this->title = 'Удобства ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилища', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Удобства';
?>
<div class="comfort">
    <?php foreach ($stay->getComfortsSortCategory() as $i => $category): ?>
        <div class="card card-info">
            <div class="card-header"><i class="<?= $category['image'] ?>"></i> <?= $category['name'] ?></div>
            <div class="card-body">
                <?php foreach ($category['items'] as $comfort): ?>
                    <div>
                        <?= $comfort['name'] . ' ' . ($comfort['pay'] == true ? '<span class="badge badge-danger">платно</span>' : '<span class="badge badge-success">free</span>') ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>
