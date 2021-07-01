<?php

use booking\entities\user\User;
use booking\forms\forum\PostForm;
use booking\entities\forum\Category;
use booking\helpers\SysHelper;
use frontend\widgets\design\BtnSave;
use frontend\widgets\design\BtnSend;
use kalyabin\wysibb\WysiBBWidget;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;

use yii\helpers\Url;

/* @var $category Category */
/* @var  $model PostForm */
/* @var $user User */

$this->title = 'Новая тема';
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => Url::to(['/forum'])];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => Url::to(['/forum/category', 'id' => $category->id])];
$this->params['breadcrumbs'][] = $this->title;
$mobile = SysHelper::isMobile();
?>
<?php $form = ActiveForm::begin([]); ?>
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'caption')->textInput(['maxlength' => true])->label('Тема') ?>
                </div>
            </div>
            <?php $preset = $user->preferences->isForumUpdate() ? 'full' : 'basic' ?>
            <?= $form
                ->field($model->message, 'text')
                ->textarea()
                ->label(false)
                ->widget(WysiBBWidget::class, [
                    'language' => 'ru',
                    'clientOptions' => [
                        'minheight' => $mobile ? 300 : 200,
                        'buttons' => $mobile
                            ? "bold,italic,underline,strike,|,img,link,|,quote,removeFormat"
                            :"bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,fontcolor,fontsize,|,justifyleft,justifycenter,justifyright,|,quote,removeFormat",
                    ],
                ]) ?>
            <div class="form-group">
                <?= BtnSend::widget([
                    'caption' => 'Создать',
                    'block' => false,
                ]) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>