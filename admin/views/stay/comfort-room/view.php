<?php


use booking\entities\booking\stays\Stay;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var  $stay Stay*/

$this->title = 'Удобства в комнатах ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Удобства';
?>
<div class="comfort">
    <?php foreach ($stay->getComfortsRoomSortCategory() as $i => $category): ?>
        <div class="card card-info">
            <div class="card-header"><i class="<?= $category['image'] ?>"></i> <?= $category['name'] ?></div>
            <div class="card-body">
                <?php foreach ($category['items'] as $comfort): ?>
                    <div>
                        <?= $comfort['name'] ?>
                        <?php if ($comfort['photo'] != ''): ?>
                        <a class="up-image" href="#"><i class="fas fa-file-image" style="color: #0c525d; font-size: 20px;"></i>
                            <span><img src="<?= $comfort['photo'] ?>" alt=""></span>
                                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::a('Редактировать', Url::to(['update', 'id' => $stay->id]), ['class' => 'btn btn-success']) ?>
    </div>
</div>
