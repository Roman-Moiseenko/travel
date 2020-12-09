<?php

/* @var $this yii\web\View */

use booking\entities\booking\funs\Fun;
use booking\helpers\BookingHelper;
use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var  $fun Fun*/
/* @var $dataProvider \yii\data\DataProviderInterface */

$this->title = 'Отзывы на ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Отзывы';
?>
<div class="funs-view">
    <div class="row">
        <div class="col-md-6">
            <?= \frontend\widgets\RatingWidget::widget(['rating' => $fun->rating]) ?>
            <?= count($fun->reviews) . ' отзыва(ов)'?>
        </div>
        <div class="col-md-4">
            <div class="form-group input-group input-group-sm">
                <label class="input-group-addon" for="input-sort">Сортировать:</label>
                <select id="input-sort" class="form-control" onchange="location = this.value;">
                    <?php
                    $values = [
                        '' => 'по умолчанию',
                        'created_at' => 'по дате (сначала старые)',
                        '-created_at' => 'по дате (сначала новые)',
                        'rating' => 'по оценке (сначала низкая)',
                        '-rating' => 'по оценке (сначала высокая)',
                    ];
                    $current = Yii::$app->request->get('sort');
                    ?>
                    <?php foreach ($values as $value => $label): ?>
                        <option value="<?=Html::encode(Url::current(['sort' => $value ?: null]))?>"
                                <?php if ($value === $current):?>selected="selected"<?php endif; ?>><?=$label?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="col-md-2 ">
            <div class="form-group input-group input-group-sm">
                <label class="input-group-addon" for="input-limit">Показать:</label>
                <select id="input-limit" class="form-control" onchange="location = this.value;">
                    <?php
                    $values = [15, 25, 50, 75, 100];
                    $current = $dataProvider->getPagination()->getPageSize();
                    ?>
                    <?php foreach ($values as $value): ?>
                        <option value="<?=Html::encode(Url::current(['per-page' => $value ?: null]))?>"
                                <?php if ($value === $current):?>selected="selected"<?php endif; ?>><?=$value?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
    </div>
    <?php foreach ($dataProvider->getModels() as $review): ?>
    <div class="row p-2">
        <div class="col-2"></div>
        <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div>
                        <?= \frontend\widgets\RatingWidget::widget(['rating' => $review->vote]) ?>
                    </div>
                    <div class="select-text">
                        <?= $review->user->personal->fullname->getFullname() ?>
                    </div>
                    <div class="ml-auto">
                        <?= date('d-m-Y', $review->created_at) ?>
                    </div>
                    <div class="pl-2">
                        <a href="<?= Url::to(['cabinet/dialog/petition', 'id' => $review->id . BookingHelper::BOOKING_TYPE_FUNS])?>" title="Подать жалобу"><i class="fas fa-share-square"></i></a>
                    </div>
                </div>
                <hr/>
                <div class="p-3">
                    <?= $review->text ?>
                </div>

            </div>
        </div>
        </div>
    </div>
    <?php endforeach; ?>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-sm-3 text-left">
            <?=LinkPager::widget([
                'pagination' => $dataProvider->getPagination(),
            ])?>
        </div>
        <div class="col-sm-3 text-right">Показано <?= $dataProvider->getCount()?> из <?= $dataProvider->getTotalCount()?></div>
    </div>
</div>
