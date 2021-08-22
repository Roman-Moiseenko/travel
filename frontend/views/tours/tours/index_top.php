<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchTourForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use booking\helpers\Emoji;
use yii\data\DataProviderInterface;
$this->title = Lang::t('Экскурсии по Калининграду обзорная, замки, форты - недорого');
$this->params['emoji'] = Emoji::TOUR;
?>

<div class="list-tours">
    <h1><?= Lang::t('Экскурсии по Калининграду и области') ?></h1>
    <?= $this->render('_search_top', ['model' => $model]) ?>
    <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
</div>
