<?php

use booking\entities\admin\User;
use booking\entities\forum\Message;
use booking\entities\forum\Post;
use booking\helpers\ForumHelper;
use mihaildev\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $post Post */
/* @var $dataProvider DataProviderInterface */
/* @var $message Message */
/* @var $user User */

$this->title = $post->caption;
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['/forum']];
$this->params['breadcrumbs'][] = ['label' => $post->category->name, 'url' => ['/forum/category', 'id' => $post->category_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card">
    <div class="card-body">

        <?php foreach ($dataProvider->getModels() as $i => $message): ?>
            <div class="card <?= ($i % 2 == 0) ? 'bg2' : 'bg1' ?>">
                <div class="card-body ">
                    <table width="100%">
                        <tbody>
                        <tr>
                            <td class="pr-4" valign="top">
                                <div class="d-flex">
                                    <div>
                                        <b><?= date('d-m-Y, H:i', $message->created_at) . ($message->updated_at ? ' изменено ' . date('d-m-Y, H:i', $message->updated_at) : '') ?></b>
                                    </div>
                                    <div class="ml-auto">

                                        <?php if ($post->isActive() && $user->id == $message->user_id && !$user->preferences->isForumLock()): ?>
                                            <a class="btn btn-default" href="<?= Url::to(['forum/update-message', 'id' => $message->id])?>"><i class="fas fa-pen"></i></a>
                                            <a class="btn btn-default" href="<?= Url::to(['forum/remove-message', 'id' => $message->id])?>"><i class="fas fa-trash"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?= Yii::$app->formatter->asHtml($message->text, [
                                    'Attr.AllowedRel' => array('nofollow'),
                                    'HTML.SafeObject' => true,
                                    'Output.FlashCompat' => true,
                                    'HTML.SafeIframe' => true,
                                    'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                                ]) ?>
                            </td>
                            <td class="ml-3" width="200px" valign="top">
                                <div class="forum-user">
                                    <div><b><?= $message->user->username ?></b></div>
                                    <div class="pb-1" style="font-size: 13px"><?= ForumHelper::status($message->user->preferences->forum_role) ?></div>
                                    <?php if (!empty($message->user->personal->photo)): ?>
                                        <img src="<?= Html::encode($message->user->personal->getThumbFileUrl('photo', 'forum')) ?>"
                                             alt=""
                                             class="img-responsive"/>
                                    <?php else: ?>
                                        <img src="<?= Url::to('@static/files/images/no_user.png') ?>" alt=""
                                             class="img-forum"/>
                                    <?php endif; ?>
                                    <div class="pt-1" style="font-size: 11px; ">
                                        <?= 'Зарегистрирован: ' . date('d-m-Y', $message->user->created_at) ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="row">
            <div class="col-sm-6 text-left">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->getPagination(),
                ]) ?>
            </div>
            <div class="col-sm-6 text-right"><?= 'Показано ' . $dataProvider->getCount() . ' из ' . $dataProvider->getTotalCount() ?></div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <?php if ($post->isActive()): ?> <!-- Если тема не заблокирована-->
                    <?php if ($user->preferences->isForumLock()): ?><!-- Если пользователь не заблокирован-->
                        <span>Вы не можете оставить сообщение, обратитесь к Модератору</span>
                    <?php else: ?>
                        <?php $form = ActiveForm::begin([]); ?>
                        <label>Новое сообщение</label>
                        <?php $preset = $user->preferences->isForumUpdate() ? 'full' : 'basic' ?><!-- Уровень доступа -->
                        <?= $form->field($model, 'text')->textarea(['rows' => 6])->label(false)->widget(CKEditor::class, [
                        'editorOptions' => [
                            'preset' => $preset, //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                        ],
                    ]) ?>
                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <span>Данная тема закрыта, и добавлять сообщения невозможно</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>