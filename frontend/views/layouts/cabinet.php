<?php
/* @var $this \yii\web\View */

/* @var $content string */

use booking\entities\Lang;
use frontend\widgets\UserMenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
$this->params['notMap'] = true;

?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

    <div class="row">
        <div id="content" class="col-sm-9">
            <?= $content ?>
        </div>

        <aside id="column-right" class="col-sm-3 hidden-xs">
                <div class="list-group">
                <?php if (\Yii::$app->user->isGuest): ?>
                    <a href="<?= Html::encode(Url::to(['/auth/auth/login'])) ?>" class="list-group-item"><?= Lang::t('Вход') ?></a>
                    <a href="<?= Html::encode(Url::to(['/signup'])) ?>"
                       class="list-group-item"><?= Lang::t('Регистрация') ?></a>
                <?php else: ?>
                    <?= UserMenuWidget::widget([
                        'type' => UserMenuWidget::CABINET_USERMENU,
                        'class_list' => 'list-group-item',
                    ]) ?>
                <?php endif; ?>
            </div>
        </aside>
    </div>
<?php $this->endContent() ?>