<?php

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<footer class="pb-2">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <label class="footer-title"><?= Lang::t('Информация') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Html::encode(Url::to(['/about'])) ?>"><?= Lang::t('О нас') ?></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/useful'])) ?>" rel="nofollow"><?= Lang::t('Полезная информация') ?></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/forum'])) ?>"><?= Lang::t('Форум') ?></a></li>
                    <li>
                        <a href="<?= Html::encode(Url::to(['/policy'])) ?>"
                           rel="nofollow"><?= Lang::t('Политика конфиденциальности') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/offer'])) ?>" rel="nofollow"><?= Lang::t('Оферта') ?></a>
                    </li>
                    <li><a href="<?= Html::encode(Url::to(['/post'])) ?>">
                            <h3><?= Lang::t('Достопримечательности Калининграда') ?></h3></a></li>
                    <li><a href="<?= Html::encode(Url::to(['/night/nochnaya-zhizn-v-kaliningrade'])) ?>">
                            <h3><?= Lang::t('Ночная жизнь в Калининграде') ?></h3></a></li>

                    <li><a href="<?= Html::encode(Url::to(['/map'])) ?>"
                           rel="nofollow"><?= Lang::t('Карта сайта') ?></a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-4">
                <label class="footer-title"><?= Lang::t('Проживание в Калининграде') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Url::to(['/stays/recreation']) ?>"><h3><?= Lang::t('Базы отдыха и глэмпинги') ?></h3></a></li>

                    <li><a href="<?= Url::to(['/stays/hotel']) ?>"><h3><?= Lang::t('Отели и Хостелы') ?></h3></a>
                    <li><a href="<?= Url::to(['/stays/house']) ?>"><h3><?= Lang::t('Дома целиком, виллы') ?></h3></a></li>
                    <li><a href="<?= Url::to(['/stays/flat']) ?>"><h3><?= Lang::t('Квартиры комфорт и премиум') ?></h3></a></li>
                    </li>
                    <li>
                        <hr/>
                    </li>
                    <li><a href="<?= Url::to(['/foods']) ?>"><h3><?= Lang::t('Где поесть в Калининграде') ?></h3></a>
                    </li>
                    <li><a href="<?= Url::to(['/shops']) ?>"><h3><?= Lang::t('Что привезти из Калининграда') ?></h3></a>
                    </li>

                </ul>
            </div>
            <div class="col-sm-4">
                <label class="footer-title"><?= Lang::t('Услуги') ?></label>
                <ul class="list-unstyled">
                    <li><a href="<?= Url::to(['/medicine']) ?>"><h3><?= Lang::t('Медицинский туризм') ?></h3></a>
                    <li><a href="<?= Url::to(['/tours']) ?>"><h3><?= Lang::t('Экскурсии в Калининграде') ?></h3></a>
                    <li><a href="<?= Url::to(['/cars']) ?>"><h3><?= Lang::t('Прокат автомобиля') ?></h3></a></li>
                    </li>
                    <li><a href="<?= Url::to(['/funs']) ?>"><h3><?= Lang::t('Развлечения и отдых') ?></h3></a></li>
                    <li><a href="<?= Url::to(['/moving']) ?>"><h3><?= Lang::t('На ПМЖ в Калининград') ?></h3>
                        </a></li>
                    <li><a href="<?= Url::to(['/realtor']) ?>"><h3><?= Lang::t('Земля и Недвижимость') ?></h3></a></li>

                </ul>
            </div>

        </div>

        <hr>
        <div class="float-right d-none d-sm-inline">
            <div>
                <?= '';//Html::a('Стать Провайдером услуг', \Yii::$app->params['adminHostInfo'], ['rel' => 'nofollow']) ?>
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
            <!--a href="https://www.instagram.com/koenigs.ru" target="_blank" rel="nofollow">
                <img src="https://static.koenigs.ru/cache/files_contacts/list_3.png" alt="Инстаграм koenigs.ru"
                     title="Инстаграм koenigs.ru" width="20" height="20"/> koenigs.ru
            </a-->
            <a href="https://vk.com/koenigsru" target="_blank" rel="nofollow">
                <img src="https://static.koenigs.ru/cache/files_contacts/list_4.png" alt="Вконтакте koenigs.ru"
                     title="Вконтакте koenigs.ru" width="20" height="20"/> koenigsru
            </a>
            <!--a href="https://website39.site"
                                             target="_blank">https://website39.site</a-->
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
                    E-mail: <span itemprop="email">koenigs.ru@gmail.com</span>
                </div>
            </div>
        </div>
    </div>
    <div id="upbutton" class="button-scroll-up"></div>
</footer>

