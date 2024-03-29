<?php

use booking\entities\Lang;
use booking\entities\moving\CategoryFAQ;
use booking\entities\user\User;
use booking\forms\moving\AnswerForm;
use booking\forms\moving\QuestionForm;
use booking\helpers\scr;
use frontend\widgets\design\BtnSend;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $category CategoryFAQ */
/* @var $model QuestionForm */
/* @var $model_answer AnswerForm */
/* @var $dataProvider DataProviderInterface */
/* @var $user User */

$js = <<<JS
$('.answer-btn').on('click', function() {
  let _id = $(this).data('id');
  $('#send-answer').attr('action', '/moving/faq/answer/' + _id)
})
JS;
$this->registerJs($js);
$this->title = $category->caption . ' вопросы-ответы';
$this->params['canonical'] = Url::to(['/moving/faq/category', 'id' => $category->id], true);

$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => Url::to(['/moving/faq'])];
$this->params['breadcrumbs'][] = $this->title = $category->caption;

if ($user && $user->username == \Yii::$app->params['moving_moderator']) {$iModerator = true;}
else {$iModerator = false;}
?>

<h1><?= $category->caption ?></h1>
<div class="my-4" style="background-color: white; border-radius: 20px; padding: 20px">
    <?= $category->description ?>
</div>

<div class="row row-cols-1 params-moving">
    <?php foreach ($dataProvider->getModels() as $faq): ?>
        <?= $this->render('_faq', [
            'faq' => $faq,
            'iModerator' => $iModerator,
        ]) ?>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-sm-6 text-left">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </div>
    <div class="col-sm-6 text-right"><?= Lang::t('Показано') . ' ' . $dataProvider->getCount() . ' ' . Lang::t('из') . ' ' . $dataProvider->getTotalCount() ?></div>
</div>

<?php if (!$iModerator): ?>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card" style="border-radius: 20px">
            <div class="card-header" style="border-radius: 20px">Задать свой вопрос</div>
            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'enableClientValidation' => false,
                ]); ?>
                <?= $form->field($model, 'username')->textInput(['style' => 'width: 70%'])->label('Ваше имя:') ?>
                <?= $form->field($model, 'email')->textInput(['style' => 'width: 70%'])->label('Ваша электронная почта:')->hint('Укажите, если хотите получить ответ на почту') ?>
                <?= $form->field($model, 'question')->textarea(['rows' => 7])->label('Вопрос:') ?>
                <?= $form->field($model, 'verifyCodeMy')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])->label('Введите код с картинки') ?>
                <div class="row">
                    <div class="col-lg-6 col-md-9">
                        <?= BtnSend::widget(['caption' => 'Отправить']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="translateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="translateModalLabel">Ответить клиенту</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'send-answer',
                'enableClientValidation' => false,
                'action' => '/moving/faq/answer',
            ]); ?>
            <div class="modal-body">
                <?= $form->field($model_answer, 'answer')->textarea(['rows' => 7])->label(false) ?>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <?= BtnSend::widget(['caption' => 'Отправить']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>