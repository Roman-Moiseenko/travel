<?php

use booking\entities\survey\Question;
use booking\forms\survey\QuestionForm;
/* @var $this yii\web\View */
/* @var $survey Survey */
/* @var $question Question */
/* @var $model QuestionForm */

use booking\entities\survey\Survey;
use yii\helpers\Url;

$this->title = 'Создать Вариант';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => Url::to(['/moving/survey'])];
$this->params['breadcrumbs'][] = ['label' => $survey->caption, 'url' => Url::to(['/moving/survey/view', 'id' => $survey->id])];
$this->params['breadcrumbs'][] = ['label' => $question->question, 'url' => Url::to(['/moving/question/view', 'id' => $question->id])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">
    <?= $this->render('_form-variant', [
        'model' => $model,
    ]) ?>
</div>
