<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \shop\forms\auth\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Список всех туров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-verification-email">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Список всех Туров на ближащие дни</p>

    <div class="row">
        <div class="col-lg-5">

            <a href="<?=Url::to(['tours/category/' . 77])?>">Туры в категории 77</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">

            <a href="<?=Url::to(['tour/' . 999])?>">Тур 999</a>
        </div>
    </div>
</div>
