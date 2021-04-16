<?php


use booking\helpers\shops\ShopTypeHelper;
use booking\helpers\StatusHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои магазины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <p>
        <?= Html::a('Создать Магазин (Онлайн)', Url::to('shop/create'), ['class' => 'btn btn-success']) ?>
        <?= Html::a('Создать Витрину (Реклама)', Url::to('shop-ad/create'), ['class' => 'btn btn-success']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
                <tr>
                    <th data-label="Тип" width="10%">Тип</th>
                    <th data-label="Название">Название</th>
                    <th data-label="Категория" width="10%">Категория</th>
                    <th data-label="Статус">Статус</th>
                </tr>
                <?php foreach ($dataProvider->getModels() as $model):?>
                <tr>
                    <td><?= $model['type_shop'] ?></td>
                    <td><?= Html::a(Html::encode($model['name']), [$model['url']]); ?></td>
                    <td><?= ShopTypeHelper::list()[$model['type_id']] ?></td>
                    <td><?= StatusHelper::statusToHTML($model['status']) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
