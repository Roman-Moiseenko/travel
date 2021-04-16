<?php


use booking\entities\admin\User;
use booking\helpers\CurrencyHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProviderDeposit ActiveDataProvider */
/* @var $dataProviderDebiting ActiveDataProvider */
/* @var $user User */

$this->title = 'Баланс';
?>

<div class="card">
    <div class="card-body">
        <h2>Текущий баланс: <?= CurrencyHelper::stat($user->Balance()) ?></h2>
        <p>
            <?= Html::a('Пополнить', Url::to(['up']), ['class' => 'btn btn-info'])?>
        </p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php Pjax::begin() ?>
        <?=  $this->render('deposit', [
            'dataProviderDeposit' => $dataProviderDeposit,
        ])?>
        <?php Pjax::end() ?>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php Pjax::begin() ?>
        <?=  $this->render('debiting', [
            'dataProviderDebiting' => $dataProviderDebiting,
        ])?>
        <?php Pjax::end() ?>
    </div>
</div>