<?php

use booking\entities\user\User;
use booking\entities\forum\Post;
use booking\forms\forum\MessageForm;
use booking\helpers\SysHelper;
use frontend\widgets\design\BtnSave;
use kalyabin\wysibb\WysiBBWidget;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var  $model MessageForm */
/* @var $post Post */
/* @var $user User */
/* @var $title string */

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => Url::to(['/forum'])];
$this->params['breadcrumbs'][] = ['label' => $post->category->section->caption, 'url' => Url::to(['/forum/view', 'slug' => $post->category->section->slug])];
$this->params['breadcrumbs'][] = ['label' => $post->category->name, 'url' => Url::to(['/forum/category', 'id' => $post->category_id])];
$this->params['breadcrumbs'][] = ['label' => $post->caption, 'url' => Url::to(['/forum/post', 'id' => $post->id])];
$this->params['breadcrumbs'][] = $this->title;
$mobile = SysHelper::isMobile();
?>
<?php $form = ActiveForm::begin([]); ?>
    <div class="card">
        <div class="card-body">
            <label><?= $post->caption ?></label>
            <?php $preset = $user->preferences->isForumUpdate() ? 'full' : 'basic' ?>
            <?= $form
                ->field($model, 'text')
                ->textarea()
                ->label(false)
                ->widget(WysiBBWidget::class, [
                    'language' => 'ru',
                    'clientOptions' => [
                        'minheight' => $mobile ? 300 : 200,
                        'buttons' => $mobile
                            ? "bold,italic,underline,strike,|,img,link,|,quote,removeFormat"
                            : "bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,fontcolor,fontsize,|,justifyleft,justifycenter,justifyright,|,quote,removeFormat",
                    ],
                ]) ?>
            <div class="form-group">
                <?= BtnSave::widget() ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>