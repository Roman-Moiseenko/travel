<?php

use booking\entities\Lang;
use frontend\assets\LandAsset;
use frontend\widgets\design\BtnSend;
use frontend\widgets\info\AgentRealtorWidget;
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
    'directory' => 'realtor/map',
    'image_file' => 'map_01.jpg',
    'alt' => 'Инвестиции в земельные участки под застройку ИЖД и МКД в Калининградской области',
]); ?>
<div class="container params-moving pt-4 text-block">

    <h2>Инвестиции для начинающих в земельные проекты с доходностью 50% годовых</h2>
    <p>
        Если у Вас есть больше 10 млн рублей альтернативой инвестиций в рискованные АКЦИИ будут – надежные инвестиции в
        землю под проекты по Застройке участка домами.
    </p>
    <p>
        ВАМ ДАЖЕ НЕ ПРИДЕТСЯ СТРОИТЬ – ВСЕ ПОД КЛЮЧ.
    </p>
    <p>
        ИНВЕСТИРОВАЛСЯ В ЗЕМЛЮ &#9658; ОФОРМИЛ ЕЕ НА СЕБЯ &#9658; ЗАКЛЮЧИЛ С НАМИ ДОГОВОР &#9658; МЫ ЗА СВОИ ДЕНЬГИ
        СДЕЛАЛИ ИНФРАСТРУКТУРУ И ПОСТРОИЛИ ДОМА &#9658; РАСПРОДАЛИ ГОТОВЫЕ ДОМА и КВАРТИРЫ &#9658; ВЫ ПОЛУЧИЛИ 100% за
        ГОД.
    </p>
    <p>
    <p>Альтернатива для тех кто покупал акции и биткоины, квартиры и золото.</p>
    <p>Отличный вариант инвестирования для моряков и инвесторов.</p>
    <p>Гарантируем высокий доход и выход из проекта, обеспечиваем все под ключ (проектирование, строительство и продажа земли с домами и квартирами)</p>
    <p>
        <a href="#land">Наше предложение по инвестированию в землю с высокой доходностью</a>
    </p>
    <h2>Куда вложить деньги в 2022 году, чтобы получать доход?</h2>

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
        Мы подбираем и формляем земельные участки и регистрируем их на Вас.
    </p>
    <p>Проводим нарезеку участков под ИЖД или МКД и обеспечиваем их инфраструктурой</p>

    <p>Организуем Строительство, технический надзор и сдачу домов</p>

    <p>Организуем интернет продажу участков для переезжающих на ПМЖ</p>


<h2 class="pb-2">Карта инвестиционных участков земли</h2>
<span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
      data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<div id="map-lands" style="width: 100%; height: 600px;"></div>


    <p id="land"></p>
    <?php foreach ($lands as $land): ?>
        <?= $this->render('_invest', ['land' => $land]) ?>
    <?php endforeach; ?>

<h2 class="pt-4">Информация для Инвестора</h2>

    <p class="pt-3">Перечень оказываемых услуг в сфере инвестиции и еще чего-то, Вы можете узнать на нашей странице <a
                href="https://koenigs.ru/realtor/page/agentstvo-privat-nedvizhimost-v-kaliningrade" rel="nofollow">Агентство</a>
    </p>
    <p>Юридическими вопросами занимаются наши партнеры <a href="https://koenigs.ru/out-link?link=https://dekorum39.ru/"
                                                          rel="nofollow">"Декорум"</a></p>
    <p class="pt-3">Также Вы можете позвонить нашему специалисту</p>
    <?= AgentRealtorWidget::widget() ?>

    <h3 class="pt-5">Анкета для инвестора</h3>
    <p>
        У нас еще очень много земельных участков в каталоге (от 1 Га и больше). </p>
    <p>Если Вам нужен участок под застройку и продажу МКД, то заполните нашу Анкету и мы подберем Вам индивидуально участок для инвестиции
    </p>
    <?= BtnSend::widget([
        'caption' => 'Заполнить Анкету',
        'block' => false,
        'url' => 'https://forms.gle/v21QaePoZxoHmoSt9',
    ]) ?>
</div>