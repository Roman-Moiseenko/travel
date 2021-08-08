<?php

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<footer class="pb-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <label class="footer-title"><?= Lang::t('Информация') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Html::encode(Url::to(['/about'])) ?>"><?= Lang::t('О сайте') ?></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/contacts'])) ?>"
                           rel="nofollow"><?= Lang::t('Контакты') ?></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/forum'])) ?>"><?= Lang::t('Форум') ?></a></li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/policy'])) ?>"
                           rel="nofollow"><?= Lang::t('Политика конфиденциальности') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/offer'])) ?>" rel="nofollow"><?= Lang::t('Оферта') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/post'])) ?>">
                            <h3><?= Lang::t('Достопримечательности Калининграда') ?></h3></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/night'])) ?>">
                            <h3><?= Lang::t('Ночная жизнь в Калининграде') ?></h3></a></li>
                </ul>
            </div>
            <?php //TODO Жилье ?>
            <div class="col-sm-3">
                <label class="footer-title"><?= Lang::t('Жилье в Калининграде') ?></label>
                <ul class="list-unstyled">
                    <!--li><a href=""><?= Lang::t('Отели') ?> (*)</a></li-->
                    <!--li><a href=""><?= Lang::t('Хостелы') ?> (*)</a></li-->
                    <li><a href="<?= Url::to(['/stays']) ?>"><h3><?= Lang::t('Апартаменты/дома целиком') ?></h3></a>
                    </li>
                    <li>
                        <hr/>
                    </li>
                    <li><a href="<?= Url::to(['/foods']) ?>"><h3><?= Lang::t('Где поесть в Калининграде') ?></h3></a>
                    </li>
                    <li><a href="<?= Url::to(['/shops']) ?>"><h3><?= Lang::t('Что привезти из Калининграда') ?></h3></a>
                    </li>
                    <!--li><a href=""><?= Lang::t('Загородные дома') ?> (*)</a></li-->
                </ul>
            </div>
            <div class="col-sm-3">
                <label class="footer-title"><?= Lang::t('Услуги') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Url::to(['/cars']) ?>"><h3><?= Lang::t('Прокат автотранспорта') ?></h3></a></li>
                    <li><a href="<?= Url::to(['/tours']) ?>"><h3><?= Lang::t('Экскурсии в Калининграде') ?></h3></a>
                    </li>
                    <li><a href="<?= Url::to(['/funs']) ?>"><h3><?= Lang::t('Развлечения и отдых') ?></h3></a></li>
                    <li><a href="<?= Url::to(['/moving']) ?>"><h3><?= Lang::t('Переезд на ПМЖ в Калининград') ?></h3>
                        </a></li>
                    <li><a href="<?= Url::to(['/lands']) ?>"><h3><?= Lang::t('Земля и Недвижимость') ?></h3></a></li>
                    <li><a href=""><?= '' //TODO Lang::t('Купить билет на представление')  ?></a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <label class="footer-title"><?= Lang::t('Личный кабинет') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Html::encode(Url::to(['/cabinet/profile'])) ?>"
                           rel="nofollow"><?= Lang::t('Кабинет') ?></a></li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/cabinet/booking/index'])) ?>"
                           rel="nofollow"><?= Lang::t('Бронирования') ?></a>
                    </li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/cabinet/wishlist/index'])) ?>"
                           rel="nofollow"><?= Lang::t('Избранное') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/cabinet/dialogs'])) ?>"
                           rel="nofollow"><?= Lang::t('Сообщения') ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <hr>
        <div class="float-right d-none d-sm-inline">
            <div>
                <?= Html::a('Стать Провайдером услуг', \Yii::$app->params['adminHostInfo'], ['rel' => 'nofollow']) ?>
            </div>
            <div>
                <a href="https://metrika.yandex.ru/stat/?id=70580203&amp;from=informer"
                   target="_blank" rel="nofollow"><img
                            src="https://informer.yandex.ru/informer/70580203/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                            style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика"
                            title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)"
                            class="ym-advanced-informer" data-cid="70580203" data-lang="ru"/></a>
            </div>
        </div>
        <p>
            <a href="https://www.instagram.com/koenigs.ru" target="_blank" rel="nofollow">
                <img src="https://static.koenigs.ru/cache/files_contacts/list_3.png" alt="Инстаграм koenigs.ru"
                     title="Инстаграм koenigs.ru" width="20px" height="20px"/> koenigs.ru
            </a>
            <a href="https://vk.com/koenigsru" target="_blank" rel="nofollow">
                <img src="https://static.koenigs.ru/cache/files_contacts/list_4.png" alt="Вконтакте koenigs.ru"
                     title="Вконтакте koenigs.ru" width="20px" height="20px"/> koenigsru
            </a>
            <?= Lang::t('Разработано') ?> <a href="mailto:koenigs.ru@gmail.com"
                                             target="_blank" rel="=nofollow"><?= Lang::t('ООО Кёнигс.РУ') ?></a>
            &copy; 2020-<?= date('Y', time()) ?> <?= Lang::t('Все права защищены') ?>
        </p>
        <div>
            <div>
                <div itemscope itemtype="https://schema.org/Organization">
                    <link itemprop="url" href="<?= \Yii::$app->params['frontendHostInfo'] ?>"/>
                    <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                        <link itemprop="contentUrl"
                              href="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/logo-admin.jpg'; ?>"/>
                    </div>
                    <span itemprop="name">ООО "Кёнигс.РУ"</span>
                    <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                        <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                        <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                        <span itemprop="addressLocality"><?= \Yii::$app->params['address']['addressLocality'] ?></span>
                    </div>
                    Телефон:<span itemprop="telephone">+7-911-471-0701</span>,
                    E-mail: <span itemprop="email">koenigs.ru@gmail.com</span>
                </div>
            </div>
        </div>
    </div>
</footer>

