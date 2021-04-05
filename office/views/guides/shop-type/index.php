<?php
use booking\entities\shops\TypeShop;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $types TypeShop[] */

$this->title = 'Категории магазинов';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="shop-type-list">
    <p>
        <?= Html::a('Создать Категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="card adaptive-width-70">
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Ссылка</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($types as $type): ?>
                <tr>
                    <td data-label="ID"><?= $type->id ?></td>
                    <td data-label="Название"><?= $type->name ?></td>
                    <td data-label="Ссылка"><?= $type->slug ?></td>
                    <td>
                        <a href="<?= Url::to(['update', 'id' => $type->id])?>"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $type->id], [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить Категорию?',
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