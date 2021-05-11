<?php

use booking\entities\admin\User;
use booking\entities\admin\forum\Message;
use booking\entities\admin\forum\Post;
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
        <table class="table">
            <tbody>
            <?php foreach ($dataProvider->getModels()  as $message): ?>
            <tr>
                <td width="200px" style="background-color: #ececec">
                    <div class="align-items-center"><b><?=$message->user->username ?></b></div>
                    <?php if (!empty($message->user->personal->photo)): ?>
                        <img src="<?= Html::encode($message->user->personal->getThumbFileUrl('photo', 'profile')) ?>" alt=""
                             class="img-responsive"/>
                    <?php else: ?>
                        <img src="<?= Url::to('@static/files/images/no_user.png') ?>" alt=""
                             class="img-responsive"/>
                    <?php endif; ?>
                    <div style="font-size: 11px; "><b><?= 'Зарегистрирован ' . date('d-m-Y', $message->user->created_at) ?></b></div>
                </td>
                <td>
                    <div class="d-flex" style="background-color: #ececec; margin-left: -12px; margin-top: -12px; margin-right: -12px; padding: 8px">
                        <div class="ml-auto">
                            <?= date('d-m-Y H:i', $message->created_at) ?>
                            <?php if ($user->id == $message->user_id): ?>
                                <i class="fas fa-pen"></i> <i class="fas fa-trash"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= Yii::$app->formatter->asHtml($message->text, [
                        'Attr.AllowedRel' => array('nofollow'),
                        'HTML.SafeObject' => true,
                        'Output.FlashCompat' => true,
                        'HTML.SafeIframe' => true,
                        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    ]) ?>
                    <div>
                        <?= $message->updated_at ? 'Изменено ' . date('d-m-Y', $message->updated_at) : '' ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
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
                <?php if($post->isActive()):?>
                    <?php $form = ActiveForm::begin([]); ?>
                    <label>Новое сообщение</label>
                    <?php $preset = $user->preferences->isForumUpdate() ? 'full' : 'basic' ?>
                    <?= $form->field($model, 'text')->textarea(['rows' => 6])->label(false)->widget(CKEditor::class, [
                        'editorOptions' => [
                            'preset' => $preset, //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            ],
                        ]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                <?php else: ?>
                    <span>Данная тема закрыта, и добавлять сообщения невозможно</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>