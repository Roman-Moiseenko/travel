<?php

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<footer class="pb-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h5><?= Lang::t('Информация') ?></h5>
                <ul class="list-unstyled">
                    <li><a href="<?= Html::encode(Url::to(['/about'])) ?>"><?= Lang::t('О сайте') ?></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/contacts'])) ?>"><?= Lang::t('Контакты') ?></a></li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/policy'])) ?>"><?= Lang::t('Политика конфиденциальности') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/offer'])) ?>"><?= Lang::t('Оферта') ?></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/post'])) ?>"><?= Lang::t('Блог') ?></a></li>
                </ul>
            </div>
            <?php //TODO Жилье ?>
            <!--div class="col-sm-3">
                <h5><?= Lang::t('Жилье') ?></h5>
                <ul class="list-unstyled">
                    <li><a href=""><?= Lang::t('Отели') ?> (*)</a></li>
                    <li><a href=""><?= Lang::t('Хостелы') ?> (*)</a></li>
                    <li><a href=""><?= Lang::t('Аппартаменты') ?> (*)</a></li>
                    <li><a href=""><?= Lang::t('Загородные дома') ?> (*)</a></li>
                </ul>
            </div-->
            <div class="col-sm-4">
                <h5><?= Lang::t('Услуги') ?></h5>
                <ul class="list-unstyled">
                    <li><a href="<?= Url::to(['/cars']) ?>"><?= Lang::t('Прокат автотранспорта') ?></a></li>
                    <li><a href="<?= Url::to(['/tours']) ?>"><?= Lang::t('Найти тур') ?></a></li>
                    <li><a href="<?= Url::to(['/funs']) ?>"><?= Lang::t('Развлечения') ?></a></li>
                    <li><a href=""><?= '' //TODO Lang::t('Купить билет на представление') ?></a></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <h5><?= Lang::t('Личный кабинет') ?></h5>
                <ul class="list-unstyled">
                    <li><a href="<?= Html::encode(Url::to(['/cabinet/profile'])) ?>"><?= Lang::t('Кабинет') ?></a></li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/cabinet/booking/index'])) ?>"><?= Lang::t('Бронирования') ?></a>
                    </li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/cabinet/wishlist/index'])) ?>"><?= Lang::t('Избранное') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/cabinet/dialogs'])) ?>"><?= Lang::t('Сообщения') ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <hr>
            <div class="float-right d-none d-sm-inline">
                <?= Html::a('Стать Провайдером услуг', \Yii::$app->params['adminHostInfo']) ?>
            </div>
            <p>
                <a href=" 	https://www.instagram.com/koenigs.ru" target="_blank"><img src="https://static.koenigs.ru/cache/files_contacts/list_3.png" /> koenigs.ru</a>
                <a href="https://vk.com/koenigsru" target="_blank"><img src="https://static.koenigs.ru/cache/files_contacts/list_4.png" /> koenigsru</a>

                <?= Lang::t('Разработано') ?> <a href="mailto:koenigs.ru@gmail.com"
                                                target="_blank"><?= Lang::t('ООО Кёнигс.РУ') ?></a>
                &copy; 2020 <?= Lang::t('Все права защищены') ?>
            </p>
    </div>
</footer>

