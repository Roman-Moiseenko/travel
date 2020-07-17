<?php
/* @var $this \yii\web\View */

/* @var $content string */

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

    <div class="row">
        <div id="content" class="col-sm-9">
            <?= $content ?>
        </div>

        <aside id="column-right" class="col-sm-3 hidden-xs">
            <div class="list-group">
                <?php if (\Yii::$app->user->isGuest): ?>
                    <a href="<?= Html::encode(Url::to(['/auth/auth/login'])) ?>" class="list-group-item"><?= Lang::t('Вход') ?></a>
                    <a href="<?= Html::encode(Url::to(['/auth/signup'])) ?>"
                       class="list-group-item"><?= Lang::t('Регистрация') ?></a>
                <?php else: ?>
                    <a href="<?= Html::encode(Url::to(['/auth/reset/request'])) ?>" class="list-group-item"><?= Lang::t('Восстановить пароль') ?></a>
                    <a href="<?= Html::encode(Url::to(['/cabinet/default/index'])) ?>"
                       class="list-group-item"><?= Lang::t('Кабинет') ?></a>
                    <a href="<?= Html::encode(Url::to(['/cabinet/wishlist/index'])) ?>" class="list-group-item"><?= Lang::t('Избранное') ?></a>
                <?php endif; ?>
            </div>
        </aside>
    </div>
<?php $this->endContent() ?>