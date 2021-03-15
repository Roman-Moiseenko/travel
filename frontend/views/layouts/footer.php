<?php

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<footer class="pb-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <label class="footer-title"><?= Lang::t('Информация') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Html::encode(Url::to(['/about'])) ?>"><?= Lang::t('О сайте') ?></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/contacts'])) ?>" rel="nofollow"><?= Lang::t('Контакты') ?></a></li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/policy'])) ?>" rel="nofollow"><?= Lang::t('Политика конфиденциальности') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/offer'])) ?>" rel="nofollow"><?= Lang::t('Оферта') ?></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/post'])) ?>"><?= Lang::t('Блог') ?></a></li>
                </ul>
            </div>
            <?php //TODO Жилье ?>
            <!--div class="col-sm-3">
                <label><?= Lang::t('Жилье') ?></label>
                <ul class="list-unstyled">
                    <li><a href=""><?= Lang::t('Отели') ?> (*)</a></li>
                    <li><a href=""><?= Lang::t('Хостелы') ?> (*)</a></li>
                    <li><a href=""><?= Lang::t('Аппартаменты') ?> (*)</a></li>
                    <li><a href=""><?= Lang::t('Загородные дома') ?> (*)</a></li>
                </ul>
            </div-->
            <div class="col-sm-4">
                <label><?= Lang::t('Услуги') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Url::to(['/cars']) ?>"><?= Lang::t('Прокат автотранспорта') ?></a></li>
                    <li><a href="<?= Url::to(['/tours']) ?>"><?= Lang::t('Найти тур') ?></a></li>
                    <li><a href="<?= Url::to(['/funs']) ?>"><?= Lang::t('Развлечения') ?></a></li>
                    <li><a href=""><?= '' //TODO Lang::t('Купить билет на представление') ?></a></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <label><?= Lang::t('Личный кабинет') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Html::encode(Url::to(['/cabinet/profile'])) ?>" rel="nofollow"><?= Lang::t('Кабинет') ?></a></li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/cabinet/booking/index'])) ?>" rel="nofollow"><?= Lang::t('Бронирования') ?></a>
                    </li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/cabinet/wishlist/index'])) ?>" rel="nofollow"><?= Lang::t('Избранное') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/cabinet/dialogs'])) ?>" rel="nofollow"><?= Lang::t('Сообщения') ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <hr>
            <div class="float-right d-none d-sm-inline">
                <?= Html::a('Стать Провайдером услуг', \Yii::$app->params['adminHostInfo']) ?>
            </div>
            <p>
                <a href="https://www.instagram.com/koenigs.ru" target="_blank">
                    <img src="https://static.koenigs.ru/cache/files_contacts/list_3.png" alt="Инстаграм koenigs.ru" title="Инстаграм koenigs.ru" /> koenigs.ru
                </a>
                <a href="https://vk.com/koenigsru" target="_blank">
                    <img src="https://static.koenigs.ru/cache/files_contacts/list_4.png" alt="Вконтакте koenigs.ru" title="Вконтакте koenigs.ru"/> koenigsru
                </a>

                <?= Lang::t('Разработано') ?> <a href="mailto:koenigs.ru@gmail.com"
                                                target="_blank"><?= Lang::t('ООО Кёнигс.РУ') ?></a>
                &copy; 2020 <?= Lang::t('Все права защищены') ?>
            </p>
    </div>
</footer>

