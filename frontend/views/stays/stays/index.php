<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \booking\forms\booking\stays\search\SearchStayForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;

use booking\forms\booking\stays\search\SearchStayForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

$this->title = Lang::t('Бронирование квартир аппартаментов домов в Калининграде и на море');

?>

<div class="list-cars">
    <h1><?= Lang::t('Аренда квартир и домов в Калининграде и области') ?></h1>
    <div class="row">
        <div class="col-sm-3 p-2">
            <?= $this->render('_search', ['model' => $model]) ?>
        </div>
        <div class="col-sm-9">
            <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
        </div>
    </div>
</div>
