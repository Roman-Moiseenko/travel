<?php

use booking\entities\survey\Survey;
use booking\entities\survey\Variant;
use booking\forms\survey\SurveyUserForm;
use frontend\widgets\design\BtnSend;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $survey Survey */
/* @var $model SurveyUserForm */

$this->title = $survey->meta->title;
$this->registerMetaTag(['name' => 'description', 'content' => $survey->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $survey->meta->description]);

$this->params['canonical'] = Url::to(['/moving/survey/view', 'id' => $survey->id], true);
$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = $survey->caption;
?>
<h1><?= $survey->caption ?></h1>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
]); ?>
<?php foreach ($survey->questions as $question): ?>
    <div class="card">
        <div class="card-header"><h2><?= $question->question ?></h2></div>
        <div class="card-body">
            <?= $form->field($model, '['. $question->id .']questions')->radioList(
                ArrayHelper::map($question->variants, function (Variant $variant) {return $variant->id;}, function (Variant $variant) {return $variant->text;})
            ); ?>
        </div>
    </div>
<?php endforeach; ?>
<?= BtnSend::widget(['caption' => 'Отправить']) ?>

<?php ActiveForm::end(); ?>
<div>
    Опрос в разработке ... скоро сделаем


</div>
