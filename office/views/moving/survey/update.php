<?php

use booking\entities\survey\Survey;
use booking\forms\survey\SurveyForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $survey Survey */
/* @var $model SurveyForm */

$this->title = 'Редактировать Опрос: ' . $survey->caption;
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $survey->caption, 'url' => ['view', 'id' => $survey->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="survey-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
