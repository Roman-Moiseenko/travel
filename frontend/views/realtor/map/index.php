<?php

use booking\entities\Lang;
use frontend\assets\LandAsset;
use frontend\widgets\design\BtnSend;
use frontend\widgets\templates\ImageH2Widget;
use yii\helpers\Url;

/* @var $this \yii\web\View */

/* @var $lands \booking\entities\realtor\land\Land[] */
$this->title = 'Агентство Инвестиции в Калининградскую землю, деликатная купля-продажа участков для строительства дома и коммерческих зданий в области Карта участков';
$description = 'Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки. Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки';
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

$this->params['canonical'] = Url::to(['/realtor/map'], true);
$this->params['breadcrumbs'][] = ['label' => 'Земля', 'url' => Url::to(['/realtor'])];

$this->params['breadcrumbs'][] = 'Инвесторам';
LandAsset::register($this);


?>
<h1>Инвестиции в земельные участки под застройку ИЖД и МКД в Калининградской области</h1>

<?= ImageH2Widget::widget([
    'directory' => 'realtor',
    'image_file' => 'land_01.jpg',
    'alt' => 'Инвестиции в земельные участки под застройку ИЖД и МКД в Калининградской области',
]); ?>
<div class="container params-moving pt-4 text-block">

    <h2 class="pt-4">Инвестиции для начинающих в земельные проекты</h2>
    <p>
        Если у Вас есть больше 10 млн рублей альтернативой инвестиций в рискованные АКЦИИ будут – надежные инвестиции в
        землю под проекты по Застройке участка домами.
    </p>
    <p>
        ВАМ ДАЖЕ НЕ ПРИДЕТСЯ СТРОИТЬ – ВСЕ ПОД КЛЮЧ.
    </p>
    <p>
        ИВНЕСТИРОВАЛСЯ В ЗЕМЛЮ &#9658; ОФОРМИЛ ЕЕ НА СЕБЯ &#9658; ЗАКЛЮЧИЛ С НАМИ ДОГОВОР &#9658; МЫ ЗА СВОИ ДЕНЬГИ
        СДЕЛАЛИ ИНФРАСТРУКТУРУ И ПОСТРОИЛИ ДОМА &#9658; РАСПРОДАЛИ ГОТОВЫЕ ДОМА и КВАРТИРЫ &#9658; ВЫ ПОЛУЧИЛИ 100% за
        ГОД.

    </p>
    <h2 class="pt-4">Куда вложить деньги в 2022 году, чтобы получать доход?</h2>

    <ul>
        <li>Акции – высокий риск</li>
        <li>Облигации (Вклад) – низкий доход</li>
        <li>Квартиры – слишком дороги</li>
        <li>Золото – малый доход</li>
        <li>Земля – постоянный рост стоимости</li>

    </ul>
    <p>
        Вид разрешенного использования (ВРИ) участка определяет, подходит ли он для сельского хозяйства, садоводства,
        разведения животных или строительства.
    </p>
    <p>
        ВРИ указан в свидетельстве о праве собственности или выписке из Единого государственного реестра прав на
        недвижимое имущество (ЕГРН, бывший ЕГРП).
    </p>
    <p>
        Индивидуальное жилищное строительство — это вид разрешенного использования земли. На таком участке можно
        построить дом для постоянного проживания, получить прописку, разбить сад и огород.
        Участок может быть частью садового товарищества или располагаться на территории населенного пункта.
    </p>
    <p>
        Современные коттеджные поселки — это гармоничный симбиоз экологичности и городского комфорта
    </p>
    <p>
        Содержание дорог, охрана, уличное освещение и всесезонная уборка территории — так клиенты получают городской
        сервис, даже проживая за городом.


    </p>
    <h2 class="pt-4">Что МЫ предлагаем инвесторам?</h2>

    <p>
        Мы подбираем и формляем земельные участки и регистрируем их наа Вас.
    </p>
    <p>Проводим нарезеку участков под ИЖД или МКД и обеспечиваем их инфраструктурой</p>

    <p>Организуем Строительство, технический надзор и сдачу домов</p>

    <p>Организуем интернет продажу участков для переезжающих на ПМЖ</p>
</div>

<h2 class="pt-4 pb-2">Карта инвестиционных участков земли</h2>
<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<div id="map-lands" style="width: 100%; height: 600px;"></div>


<div class="indent text-justify pt-4">
    <?php foreach ($lands as $land): ?>
        <div class="card mt-4" style="border: 0">
            <div class="card-body params-moving" style="border: 0">
                <h3 class="pt-4"><?= $land->title ?></h3>
                <div class="item-responsive item-3-0by1">
                    <div class="content-item">
                        <img loading="lazy" src="<?= $land->getThumbFileUrl('photo', 'list_lands') ?>"/>
                    </div>
                </div>
                <p class="pt-4"><?= $land->description ?></p>
                <p><a href="<?= Url::to(['realtor/map/view', 'slug' => $land->slug]) ?>"
                      class="stretched-link">Подробнее об инвестиционном предложении</a>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<h2 class="pt-4">Информация для Инвестора</h2>
<div class="params-moving">
    <p class="pt-3">Перечень оказываемых услуг в сфере инвестиции и еще чего-то, Вы можете узнать на нашей странице <a
                href="https://koenigs.ru/realtor/page/agentstvo-privat-nedvizhimost-v-kaliningrade" rel="nofollow">Агентство</a>
    </p>
    <p>Юридическими вопросами занимаются наши партнеры <a href="https://koenigs.ru/out-link?link=https://dekorum39.ru/"
                                                          rel="nofollow">"Декорум"</a></p>
    <p class="pt-3">Также Вы можете позвонить нашему специалисту</p>
    <div class="d-flex">
        <div><img alt="Шадуйкис Олег Геннадьевич" width="200" height="200"
                                            src="https://static.koenigs.ru/images/page/about/oleg.jpg"
                                            style="border-radius: 30px;"/>

        </div>
        <div class="pl-5">
            <p style="text-align: center;"><span style="font-size:18px;"><b>Шадуйкис Олег</b></span></p>
            <p>Эксперт в области инвестиций, маркетинга и финансов. Специализация - коммерческая недвижимость и интернет-маркетинг туризма.</p>
            <?= \frontend\widgets\design\BtnPhone::widget([
                    'caption' => '8-950-676-3594',
                'block' => false,
                'phone' => '8-950-676-3594'
            ]) ?>


        </div>
        <div class="ml-auto">
        </div>
    </div>

    <h3 class="pt-5">Анкета для инвестора</h3>
    <p>
        Пройдите наше Анкетирование и мы подберем Вам индивидуально участок для инвестиций
    </p>
    <?= BtnSend::widget([
        'caption' => 'Заполнить Анкету',
        'block' => false,
        'url' => 'https://forms.gle/v21QaePoZxoHmoSt9',
    ]) ?>
</div>