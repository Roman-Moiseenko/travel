<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchTourForm */

use booking\forms\booking\tours\SearchTourForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Туры, экскурсии, мероприятия';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-verification-email">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Список всех Туров на ближащие дни</p>

    <div class="row">
        <div class="col-sm-3">
            <?= $this->render('_search_left', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-9">

            <a href="<?=Url::to(['tour/' . 999])?>">Список все туров</a>
        </div>
    </div>
</div>
