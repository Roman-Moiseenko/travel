<?php

use booking\entities\user\User;
use booking\entities\forum\Message;
use booking\entities\forum\Post;
use booking\helpers\SysHelper;
use booking\helpers\UserForumHelper;
use frontend\widgets\design\BtnSave;
use frontend\widgets\design\BtnSend;
use kalyabin\wysibb\WysiBBWidget;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this \yii\web\View */

/* @var $post Post */
/* @var $dataProvider DataProviderInterface */
/* @var $message Message */
/* @var $user User */

$this->title = $post->caption . ' Форум для туристов и гостей Калининграда';
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => Url::to(['/forum'])];
$this->params['breadcrumbs'][] = ['label' => $post->category->name, 'url' => Url::to(['/forum/category', 'id' => $post->category->id])];
$this->params['breadcrumbs'][] = $post->caption;
$mobile = SysHelper::isMobile();

?>
<h1 style="font-size: 20px !important;"><?= $post->caption ?></h1>
<div class="forum-main-style">
    <?php foreach ($dataProvider->getModels() as $i => $message): ?>
        <div class="card mt-2 <?= ($i % 2 == 0) ? 'bg2' : 'bg1' ?>">
            <div class="card-header">
                <div class="forum-user d-flex">
                    <div>
                        <?php if (!empty($message->user->personal->photo)): ?>
                            <img src="<?= Html::encode($message->user->personal->getThumbFileUrl('photo', 'forum_mobile')) ?>"
                                 alt="Фото пользователя <?= $message->user->personal->fullname->getFullname() ?>  на Форуме Калининград"
                                 class="img-responsive" style="border-radius: 12px"/>
                        <?php else: ?>
                            <img src="<?= Url::to('@static/files/images/no_user.png') ?>"
                                 alt="Нет фотографии на Форуме по Калининграду"
                                 class="img-forum" width="60px" height="60px"/>
                        <?php endif; ?>
                    </div>
                    <div class="ml-auto">
                        <div><b><?= $message->userName() ?></b></div>
                        <div class="pb-1"
                             style="font-size: 13px"><?= UserForumHelper::status($message->user->preferences->forum_role) ?></div>
                        <div class="pt-1" style="font-size: 11px; ">
                            <?= 'Зарегистрирован: ' . date('d-m-Y', $message->user->created_at) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body ">
                <div class="d-flex">
                    <div>
                        <span style="font-size: 16px; font-weight: 600"><?= ($i > 0 ? 'Re: ' : '') . $post->caption ?></span><br>
                        <span style="font-size: 10px;">
                                            <?= date('d-m-Y, H:i', $message->created_at) . ($message->updated_at ? ' изменено ' . date('d-m-Y, H:i', $message->updated_at) : '') ?>
                                        </span>
                    </div>
                    <div class="ml-auto">
                        <?php if ($user && $post->isActive() && $user->id == $message->user_id && !$user->preferences->isForumLock()): ?>
                            <a class="btn btn-default"
                               href="<?= Url::to(['forum/update-message', 'id' => $message->id]) ?>"><i
                                        class="fas fa-pen"></i></a>
                            <a class="btn btn-default"
                               href="<?= Url::to(['forum/remove-message', 'id' => $message->id]) ?>"><i
                                        class="fas fa-trash"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?= Yii::$app->formatter->asHtml(UserForumHelper::encodeBB($message->text), [
                    'Attr.AllowedRel' => array('nofollow'),
                    'HTML.SafeObject' => true,
                    'Output.FlashCompat' => true,
                    'HTML.SafeIframe' => true,
                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                ]) ?>
                <div class="d-flex pt-2">
                    <div class="ml-auto">
                        <a href="<?= Url::to(['/forum/post', 'id' => $post->id, '#' =>'top'], true); ?>" title="Вернуться к началу">
                            <i class="fas fa-chevron-circle-up"></i></div>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="row py-2">
        <div class="col-sm-6 text-left">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->getPagination(),
            ]) ?>
        </div>
        <div class="col-sm-6 text-right"><?= 'Показано ' . $dataProvider->getCount() . ' из ' . $dataProvider->getTotalCount() ?></div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if ($user): ?> <!-- Если авторизован-->
                <?php if ($post->isActive()): ?> <!-- Если тема не заблокирована-->
                <?php if ($user->preferences->isForumLock()): ?><!-- Если пользователь не заблокирован-->
                    <span>Вы не можете оставить сообщение, обратитесь к Модератору</span>
                <?php else: ?>
                    <?php $form = ActiveForm::begin([]); ?>
                    <label>Новое сообщение</label>
                    <?php $preset = $user->preferences->isForumUpdate() ? 'full' : 'basic' ?><!-- Уровень доступа -->
                    <?= $form->field($model, 'text')->textarea(['rows' => 6])->label(false)->widget(WysiBBWidget::class, [
                    'language' => 'ru',
                    'clientOptions' => [
                        'minheight' => '300',
                        'buttons' => "bold,italic,underline,strike,|,img,link,|,quote,removeFormat",
                    ],
                ]) ?>
                    <div class="form-group">
                        <?= BtnSend::widget([
                            'caption' => 'Отправить',
                            'block' => false,
                        ]) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                <?php endif; ?>
            <?php else: ?>
                <span>Данная тема закрыта, и добавлять сообщения невозможно</span>
            <?php endif; ?>
            <?php else: ?>
            <span><a href="<?= Url::to(['/login'])?>">Авторизуйтесь на сайте</a>, чтоб оставлять сообщения</span>
            <?php endif; ?>
        </div>
    </div>
</div>
