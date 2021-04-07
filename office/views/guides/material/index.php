<?php

use booking\entities\shops\products\Material;
use booking\entities\shops\TypeShop;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $materials Material[] */

$this->title = 'Материал товаров';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="shop-type-list">
    <p>
        <?= Html::a('Создать Материал', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card adaptive-width-70">
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($materials as $material): ?>
                <tr>
                    <td data-label="ID"><?= $material->id ?></td>
                    <td data-label="Название"><?= $material->name ?></td>
                    <td>
                        <a href="<?= Url::to(['update', 'id' => $material->id])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $material->id], [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить Материал?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>