<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model SearchToursForm */
/* @var $dataProvider DataProviderInterface */

use booking\forms\booking\tours\SearchToursForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

$this->title = 'Туры, экскурсии, мероприятия';
?>
<div class="site-resend-verification-email">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search_top', ['model' => $model]) ?>
    <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
</div>
