<?php

use booking\entities\survey\Questionnaire;
use booking\entities\survey\Survey;
use booking\forms\survey\QuestionnaireForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $survey Survey */
/* @var $array_questionnaire array */
/* @var $questionnaire Questionnaire */

$this->title = $survey->meta->title;
$this->registerMetaTag(['name' => 'description', 'content' => $survey->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $survey->meta->description]);

$this->params['canonical'] = Url::to(['/moving/survey/view', 'id' => $survey->id], true);
$this->params['breadcrumbs'][] = $survey->caption;

?>
<h1><?= $survey->caption ?></h1>
<?php foreach ($questionnaire->answers as $answer): ?>
    <div class="card m-3">
        <div class="card-header"><h2 style="font-size: 16px;"><?= $answer->question->question ?></h2></div>
        <div class="card-body">

        </div>
    </div>
<?php endforeach; ?>
