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
<?php foreach ($survey->questions as $question): ?>
    <div class="card m-3">
        <div class="card-header"><h2 style="font-size: 16px;"><?= $question->question ?></h2></div>
        <div class="card-body">
            <?php foreach ($question->variants as $variant):?>
            <div>
                <?= $variant->text ?>
            </div>
            <div class="progress" style="height: 20px;">
                <div class="progress-bar" role="progressbar"
                     style="width: <?= $array_questionnaire[$question->id][$variant->id] / $array_questionnaire[$question->id]['sum'] * 100 ?>%"
                     aria-valuenow="<?= $array_questionnaire[$question->id][$variant->id] ?>" aria-valuemin="0" aria-valuemax="<?= $array_questionnaire[$question->id]['sum'] ?>">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
