<?php

use booking\entities\Lang;
use frontend\assets\LandAsset;
use frontend\widgets\templates\ImageH2Widget;
use yii\helpers\Url;

/* @var $this \yii\web\View */
$this->title = 'Инвестиции в Калининградскую землю, стоимость земельных участков, купить землю, строительство, проектирование, риэлторская компания';
$this->registerMetaTag(['name' => 'description', 'content' => 'Операции с землей в Калининграде - купля-продажа, инвестиции, закрытые сделки,']);

$this->params['canonical'] = Url::to(['/realtor/investment'], true);
$this->params['breadcrumbs'][] = ['label' => 'Агентство', 'url' => Url::to(['/realtor'])];
$this->params['breadcrumbs'][] = 'Инвестиции';
LandAsset::register($this);


?>
<h1 class="pb-4">Инвестиции в Калининградскую землю</h1>
<?= ImageH2Widget::widget([
    'directory' => 'realtor/investment',
    'image_file' => 'investment_01.jpg',
    'alt' => 'Инвестиции в Калининградсую землю',
]); ?>
<div class="container params-moving pt-4 text-block">
    <p class="indent text-justify">Калининградская область имеет ограниченный потенциал земельных ресурсов. Это
        обусловлено не только географическими границами, но и ограничениями со стороны силовых ведомств (например ВС РФ)
        и крупных промышленных предприятий. В то же время вложения в недвижимость и землю частности – очень выгодны для
        инвестора и застройщика. Типовая доходность при девелопменте не опускается ниже 20% в год. Покупка земли —
        лучшая тактика прохождения кризисных явлений.</p>
    <p class="indent text-justify">Сделки по земельным участкам крайне индивидуальны и специфичны, инвестиционные
        параметры зависят от множества факторов.</p>
    <p class="indent text-justify">Большое значение имеет инфраструктурная нагрузка, подтопления и качество земли,
        удаленность от точек подключения и социальной инфраструктуры.</p>
    <p class="indent text-justify">Но всё же «основная проблема» для инвестора – это завышенные аппетиты собственников и
        наличие номинальных владельцев за которыми стоят реальные собственники ( которые принимают окончательные
        решения).</p>
    <p class="indent text-justify">В целом по Калининградской области не используется по назначению более 200 тыс.
        гектаров сельскохозяйственных угодий и примерно 50 тыс. гектаров земель поселений.</p>
    <p class="indent text-justify">Причём, эти земли взаимосвязаны и их инвестиционная привлекательность зависит от
        близости к Калининграду или побережью балтийского моря (например, Багратионовский район, Зеленоградский или
        Гурьевский городские округа, и т.п.).</p>
    <p class="indent text-justify">Это дорогая земля и заниматься сельскохозяйственным производством на ней сложно и не
        рационально. Вместо её строят коттеджные и дачные поселки, с последующим преобразованием в жилые кварталы.</p>
    <p class="indent text-justify">Например, на территории СНТ, по данным мэрии Калининграда , проживает до 10% (50.000
        человек) жителей города.</p>

    <h2>Инвестиционная стоимость земельных участков в Калининградской области в 2021 году</h2>
    <?= ImageH2Widget::widget([
        'directory' => 'realtor/investment',
        'image_file' => 'investment_02.jpg',
        'alt' => 'Инвестиционная стоимость земельных участков в Калининградской области',
    ]); ?>
    <p class="indent text-justify">Побережье (Светлогорск, Зеленоградск (Малиновка, Сосновка, Клинцовка, Лесенково),
        Заостровье, Пионерский, Сокольники, Куликово, Отрадное, Янтарный, Донское и т.п.) – стоимость от 1 000 000
        рублей за минимальный участок.</p>
    <p class="indent text-justify">Участок размером 6 соток в первой линии от моря от 5 млн.рублей до 12 миллионов
        рублей.</p>
    <p class="indent text-justify">Купить землю в собственность и построить дом на Куршской Косе - сложно, так как это
        заповедник и девелопмент ограничен федеральным законодательством.</p>
    Калининград<br>
    <p class="indent text-justify">Продажа земли с инфраструктурой начинается от 5 -8 млн.рублей по рублей за 8 соток. В
        Гурьевске купить землю под ИЖС можно за 1 600 000 рублей.</p>

    <h2>Бесплатные земельные участки</h2>
    <?= ImageH2Widget::widget([
        'directory' => 'realtor/investment',
        'image_file' => 'investment_03.jpg',
        'alt' => 'Бесплатные земельные участки',
    ]); ?>
    <p class="indent text-justify">Согласно ст. 39.5 ЗК РФ, землю можно получить бесплатно в следующих случаях:
    <ul>
        <li>если гражданин владеет участком более 5 лет со дня предоставления ему земли в безвозмездное пользование при
            условии, что соблюдался разрешенный вид землепользования;
        </li>
        <li>если земельным участком владеет многодетная семья или одинокий родитель, воспитывающий 3 и более детей;</li>
    </ul>

    <h2>Рыночная стоимость земли для инвестора</h2>
    <?= ImageH2Widget::widget([
        'directory' => 'realtor/investment',
        'image_file' => 'investment_04.jpg',
        'alt' => 'Рыночная стоимость земли для инвестора',
    ]); ?>
    <p>Существует рыночная и кадастровая стоимость.</p>
    <p>Кадастровая и рыночная цены предназначены для разных целей.</p>
    <p>Кадастровую стоимость определяют оценщики, привлеченные исполнительными органами власти и используют для
        определения налоговой базы при начислении земельного налога.</p>
    <p>Рыночная стоимость фигурирует в договорах купли-продажи земельного участка.</p>

    <h2>Факторы, влияющие на рыночную стоимость земли</h2>
    <?= ImageH2Widget::widget([
        'directory' => 'realtor/investment',
        'image_file' => 'investment_05.jpg',
        'alt' => 'Факторы, влияющие на рыночную стоимость земли',
    ]); ?>
    Рыночная цена земельного участка зависит от :
    <ul>
        <li>Транспортная доступность, близость к крупным городам.</li>
        <li>Категория земельного участка.</li>
        <li>Развитая инфраструктура: наличие школ, больниц, аптек поблизости и пр.</li>
        <li>Наличие коммуникаций на участке (газа, электричества и пр.).</li>
        <li>Наличие построек на участке.</li>
        <li>Экологические параметры: наличие леса и озера поблизости и пр.</li>
        <li>Социальное окружение проекта</li>
        <li>Удаленность от промышленных объектов.</li>
    </ul>
    Анализировать земельный участок можно при помощи кадастровой карты по ссылке pkk5.rosreestr.ru или перейти с сайта
    Росреестра.

    <h2>Правильно инвестируем в земельный участок</h2>
    <?= ImageH2Widget::widget([
        'directory' => 'realtor/investment',
        'image_file' => 'investment_06.jpg',
        'alt' => 'Правильно инвестируем в земельный участок',
    ]); ?>
    <ol>
        <li>Стоимость дома составляет как правило 80-70% от стоимости земельного участка. Строительство квартир –
            выгоднее так как меньше площадь вспомогательных помещений.
        </li>
        <li>Построен дом на участке должен быть в строго отведенное время.</li>
        <li>Если у Вас дети или Вы распродаете участки под ИЖС – вопрос лечения и обучения резко снижает или повышает
            привлекательность земли.
        </li>
        <li>Стоимость жилья и самого земельного участка в разы зависит уровня жизни вокруг него. Никакие бильярд, сауна
            и даже бассейн ценности объекту не прибавляют.
        </li>
        <li class="text-justify">ИЖС и СНТ<br>
            На дачной земле собственник может начать строительство сразу после получения свидетельства о собственности,
            плюс у такой земли более низкая ставка земельного налога.<br>
            Но существуют два вида собственности на дачные участки: общедолевая и индивидуальная.<br>
            Иногда покупатели не уделяют должного внимания этим тонкостям при выборе участка.
        </li>
        <li>Водопровод и канализация в загородном поселке - это не аналог городских систем.<br>
            Они более дороги в оформлении и строительстве. Бесперебойная работа зависит от от погодных и природных
            условий. Плюс -
            непрозрачность тарифов и платежей на обслуживание.
        </li>
    </ol>

    <h2>Правильно застраиваем земельный участок</h2>
    <?= ImageH2Widget::widget([
        'directory' => 'realtor/investment',
        'image_file' => 'investment_07.jpg',
        'alt' => 'Правильно застраиваем земельный участок',
    ]); ?>
    <h3>Строительные нормы и правила (СНиП)</h3>
    <p>– это свод нормативных актов, регулирующих строительство.</p>
    <p>Планируя возведение жилого строения на участке ИЖС необходимо соблюдать нормы строительства и застройки:</p>
    <ul>
        <li>СНиП 30-02-97. Регулирует «Красные линии» – черту, обозначающая границу между участком и зонами общего
            пользования.
        </li>
        <li>Жилой дом должен располагаться в 5 м от улицы и 3 м от проезда и границ между участками.</li>
        <li>Процент мощения участка, допустимый процент, не более 30%.</li>
        <li>СНиП 2.04.02-87 и СНиП 2.04.01-85 регулируют устройство и расположение систем водоснабжения и
            водоотведения.
        </li>
    </ul>

    <h3>Санитарные нормы</h3>
    <ul>
        <li>Санитарные нормы ИЖС предполагают что, от жилого дома до границы с земельным участком соседей должно быть не
            менее 3м;
        </li>
        <li>Хозяйственные постройки нужно располагать минимум на метр от соседей.</li>
        <li>Деревья от соседей должны быть в 4 м.</li>
    </ul>

    <h3>Требования пожарной безопасности</h3>
    <ul>
        <li>Если дом из камня, либо кирпича (негорючие материалы), то расстояние между жилыми строениями должно
            составлять от 6 м.
        </li>
        <li>Деревянные дома и коттеджи должны отстоять друг от друга на 15 м.</li>
        <li>От жилого дома здание бани должно отстоять на 8 метров, от забора со стороны улицы – на 5 метров, от границы
            с соседним участком – на один метр.
        </li>
        <li>Возведение капитального забора возможно только после заключения кадастровой экспертизы о границах земельного
            владения, и не должен превышать 1,5 метра.
        </li>
        <li>Перед строительством загородного дома необходимо составить его проект и план расположения помещений, самого
            дома на приусадебной территории и их удаления друг от друга и от границ соседских наделов.
        </li>
        <li>От дома, где проживают люди, и до ближайшего леса расстояние должно быть более ≥ 15 м.</li>
    </ul>

    <h3>Садовый участок нормы</h3>
    <ul>
        <li>Садовый участок должен иметь площадь минимум 6 соток (0,06га).</li>
        <li>Строгие правила и нормы относятся к расстоянию между жилыми домиками.</li>
        <li>Бетонный, каменный каркас не менее 6 м.</li>
        <li>Каркас из негорючих материалов (кирпич, железобетон) – не менее 8м.</li>
        <li>Замеряется расстояние от стены соседского дома или от выступающих более чем на полметра элементов.</li>
        <li>Также при строительстве дома нужно учитывать расположение красных линий. Расстояние до улицы должно быть не
            менее 5м, а до проезда – 3м.
        </li>
        <li>Для соблюдения санитарно-гигиенических норм туалет должен быть не мене 8м от соседа;</li>
        <li>То есть сарай должен быть удален на 12м от жилого дома на участке, а также от всех жилых построек на смежных
            территориях.
        </li>
        <li>На участках, размером от 6 до 12 соток разрешено занимать постройками не более 30% площади.</li>
        <li>Высота забора в СНТ ограничивается 2м, если иное не предусмотрено решением собрания садоводов.</li>
    </ul>

    <p>Если происходят какие-либо отклонения от норм и правил при застройке, их согласовывают с органами местного
        самоуправления.</p>

    <p>Требования к жилым постройкам</p>
    <p>К домам, а точнее их планировке, возведенным на дачных участках в пределах СНТ, предъявляются минимальные
        требования. Высота потолка на 30см меньше, чем при ИЖС – всего 2,2м. Размеры комнат не регламентируются.</p>
    <p>Если вы планируете посадки на своем участке, следует ознакомиться с нормами отступа от границ участка.</p>
    <p>Есть правила, которые предусматривают застройку и планировку дачных участков (СП 53.13330.2011).</p>


    Отступы от забора при строительстве дач:
    <ul>
        <li>дом – 5 метров от улицы; 3 метра от проезда</li>
        <li>баня — 5 метров</li>
        <li>гараж – 5 метров</li>
        <li>сарай – 5 метров</li>
        <li>Между жилыми строениями– от 6 до 15 метров, в зависимости от материала, из которого они сделаны.</li>
        <li>Между домом и баней – 8 метров.</li>
    </ul>

    <h3>Сосед нарушил нормы строительства – куда жаловаться?</h3>
    <p class="indent text-justify">Если в результате обращения в местные органы власти проблему решить не удалось,
        остается - суд.</p>

    <h2>Инвестиции в земли под ТЦ и БЦ</h2>
    <?= ImageH2Widget::widget([
        'directory' => 'realtor/investment',
        'image_file' => 'investment_08.jpg',
        'alt' => 'Инвестиции в земли под ТЦ и БЦ',
    ]); ?>
    <p class="indent text-justify">Инвестиции в в земли под торговую недвижимость подразумевают предварительную
        разработку концепции самого объекта и логистику движения товаро и человеко – потока.</p>

    Основные плюсы инвестирования в коммерческие земельные участки:
    <ul>
        <li>Это небольшие вложения по сравнению с жильём.</li>
        <li>Эти инвестиции считаются крайне надежными.</li>
        <li>Многофункциональность и Прибыльность в такой ситуации можно зарабатывать на обычной спекулятивной
            перепродаже земельного участка.
        </li>
    </ul>

    Основные минусы инвестирования в земельные участки под ТЦ
    <ul>
        <li>Низкий уровень ликвидности.</li>
        <li>Чаще требуется достаточно времени для того продажи по цене, приближенной к рыночной.</li>
        <li>Налоговая нагрузка, которую ежегодно должен выплачивать собственник.</li>
        <li>Собственник должен пользоваться своим активом в точном соответствии с целевым назначением.</li>
        <li>Если в будущем запланировано строительство, то нужно собрать сведения о почвах, грунтовых водах и
            проложенных коммуникациях.
        </li>
    </ul>
</div>