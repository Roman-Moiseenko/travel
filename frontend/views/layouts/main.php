<?php

/* @var $this \yii\web\View */
/* @var $content string */

use booking\entities\Lang;
use frontend\widgets\AlertWidget;
use frontend\widgets\TopmenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script src="https://api-maps.yandex.ru/2.1/?apikey=b38651ca-314e-4dd0-8919-28dd226e14e1&lang=ru_RU" type="text/javascript">
        </script>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <nav id="top"><?= TopmenuWidget::widget()?></nav>

    <div id="common-home" class="container content-container">
        <?= Breadcrumbs::widget([
            'options' => ['class' => 'breadcrumb-site'],
            'homeLink' => [
                'label' => Lang::t('Главная'),
                'url' => Yii::$app->homeUrl,
                'title' => Lang::t('На главную'),
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= AlertWidget::widget() ?>
        <?= $content ?>

    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5><?= Lang::t('Информация') ?></h5>
                    <ul class="list-unstyled">
                        <li><a href="<?=Html::encode(Url::to(['/about']))?>"><?= Lang::t('О сайте') ?></a></li>
                        <li><a href="<?=Html::encode(Url::to(['/support']))?>"><?= Lang::t('Служба поддержки') ?></a></li>
                        <li><a href="<?=Html::encode(Url::to(['/policy']))?>"><?= Lang::t('Политика конфиденциальности') ?></a></li>
                        <li><a href="<?=Html::encode(Url::to(['/post']))?>"><?= Lang::t('Блог') ?></a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5><?= Lang::t('Жилье') ?></h5>
                    <ul class="list-unstyled">
                        <li><a href=""><?= Lang::t('Отели') ?> (*)</a></li>
                        <li><a href=""><?= Lang::t('Хостелы') ?> (*)</a></li>
                        <li><a href=""><?= Lang::t('Аппартаменты') ?> (*)</a></li>
                        <li><a href=""><?= Lang::t('Загородные дома') ?> (*)</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5><?= Lang::t('Другие услуги') ?></h5>
                    <ul class="list-unstyled">
                        <li><a href=""><?= Lang::t('Прокат автомобиля') ?> (*)</a></li>
                        <li><a href="<?= Url::to(['/tours'])?>"><?= Lang::t('Найти тур') ?></a></li>
                        <li><a href=""><?= Lang::t('Заказать столик в ресторане') ?> (*)</a></li>
                        <li><a href=""><?= Lang::t('Купить билет на представление') ?> (*)</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5><?= Lang::t('Личный кабинет') ?></h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/index'])) ?>"><?= Lang::t('Кабинет') ?></a></li>
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/booking/index'])) ?>"><?= Lang::t('Бронирования') ?></a></li>
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/wishlist/index'])) ?>"><?= Lang::t('Избранное') ?></a></li>
                        <li><a href="<?= Html::encode(Url::to(['/cabinet/dialogs'])) ?>"><?= Lang::t('Сообщения') ?></a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <p><?= Lang::t('Разработано') ?> <a href="http://www.mycraft.site" target="_blank"><?= Lang::t('Моисеенко Роман Александрович') ?></a> &copy; 2020</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>

