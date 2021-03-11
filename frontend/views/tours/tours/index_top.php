<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchTourForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
$this->title = Lang::t('Туры и экскурсии по городу Калининград и области - замки, форты');
?>

<div class="list-tours">
    <h1><?= Html::encode('Туры и экскурсии по Калининграду и области') ?></h1>
    <?= $this->render('_search_top', ['model' => $model]) ?>
    <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
</div>
