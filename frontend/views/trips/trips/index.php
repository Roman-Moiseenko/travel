<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchTourForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use yii\data\DataProviderInterface;
$this->title = Lang::t('Туры в Калининград - медицинский, лечебный, семейный, для двоих, на отдых');
?>

<div class="list-tours">
    <h1><?= Lang::t('Туры в Калининград и на побережье') ?></h1>
    <?= $this->render('_search', ['model' => $model]) ?>
    <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
</div>
