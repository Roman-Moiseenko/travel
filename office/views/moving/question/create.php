<?php

use booking\forms\survey\QuestionForm;
/* @var $this yii\web\View */
/* @var $survey Survey */
/* @var $model QuestionForm */

use booking\entities\survey\Survey;
use yii\helpers\Url;

$this->title = 'Создать вопрос';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => Url::to(['/moving/survey'])];
$this->params['breadcrumbs'][] = ['label' => $survey->caption, 'url' => Url::to(['/moving/survey/view', 'id' => $survey->id])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
