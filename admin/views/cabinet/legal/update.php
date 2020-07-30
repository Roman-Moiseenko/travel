<?php

use booking\entities\admin\user\UserLegal;
use booking\forms\auth\UserLegalForm;
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
]) ?>
