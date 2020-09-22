<?php

use booking\entities\admin\UserLegal;
use booking\forms\admin\UserLegalForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model UserLegalForm*/
/* @var $legal UserLegal */

$this->title = 'Изменить ' . $legal->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'legal' => $legal,
]) ?>
