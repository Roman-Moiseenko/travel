<?php

use booking\entities\survey\Survey;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Survey */

$this->title = 'Создать Опрос';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
