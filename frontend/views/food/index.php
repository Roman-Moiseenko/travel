<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchFoodForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use booking\forms\foods\SearchFoodForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
$this->title = Lang::t('Где поесть в Калининграде - рестораны, кафе, доставка');
?>

<div class="list-tours">
    <h1><?= Lang::t('Где поесть в Калининграде и области') ?></h1>
    <?= $this->render('_search', ['model' => $model]) ?>
    <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
</div>