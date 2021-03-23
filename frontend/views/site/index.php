<?php


use booking\entities\Lang;
use kv4nt\owlcarousel\OwlCarouselWidget;

/* @var $this yii\web\View */
$this->title = Lang::t('На отдых в Калининград');
?>

<header class="landing-header">
    <div class="container">
        <noindex>
    <!-- weather widget start --><div id="m-booked-prime-20172">

            <div class="booked-wzsp-prime-in"> <div class="booked-wzsp-prime-data">
                    <div class="booked-wzsp-prime-img wt03"></div>
                    <div class="booked-wzsp-day-val"> <div class="booked-wzsp-day-number"><span class="plus">+</span>10</div> <
                        div class="booked-wzsp-day-dergee"> <div class="booked-wzsp-day-dergee-val">&deg;</div>
                        <div class="booked-wzsp-day-dergee-name">C</div> </div> </div> </div> </div> </div><script type="text/javascript">
        var css_file=document.createElement("link"); var widgetUrl = location.href; css_file.setAttribute("rel","stylesheet");
        css_file.setAttribute("type","text/css"); css_file.setAttribute("href",'https://s.bookcdn.com/css/w/booked-wzs-widget-prime.css?v=0.0.1');
        document.getElementsByTagName("head")[0].appendChild(css_file); function setWidgetData_20172(data)
        { if(typeof(data) != 'undefined' && data.results.length > 0) { for(var i = 0; i < data.results.length; ++i)
        { var objMainBlock = document.getElementById('m-booked-prime-20172'); if(objMainBlock !== null)
        { var copyBlock = document.getElementById('m-bookew-weather-copy-'+data.results[i].widget_type);
        objMainBlock.innerHTML = data.results[i].html_code; if(copyBlock !== null) objMainBlock.appendChild(copyBlock); } } } else {
            alert('data=undefined||data.results is empty'); } }
            var widgetSrc = "https://widgets.booked.net/weather/info?action=get_weather_info;ver=6;cityID=16026;type=5;scode=2;ltid=3540;domid=589;anc_id=7471;countday=undefined;cmetric=1;wlangID=20;color=137AE9;wwidth=160;header_color=ffffff;text_color=333333;link_color=08488D;border_form=1;footer_color=ffffff;footer_text_color=333333;transparent=0;v=0.0.1";
        widgetSrc += ';ref=' + widgetUrl;widgetSrc += ';rand_id=20172';widgetSrc += ';wstrackId=6149499';
        var weatherBookedScript = document.createElement("script"); weatherBookedScript.setAttribute("type", "text/javascript");
        weatherBookedScript.src = widgetSrc; document.body.appendChild(weatherBookedScript) </script><!-- weather widget end -->
    </noindex>
    </div>
</header>
<?php

OwlCarouselWidget::begin([
    'container' => 'div',
    'containerOptions' => [
        'id' => 'container-id',
        'class' => 'container-class'
    ],
    'pluginOptions' => [
        'autoplay' => true,
        'autoplayTimeout' => 5000,
        'items' => 1,
        'loop' => true,
        //    'itemsDesktop'      => [1199, 3],
        //   'itemsDesktopSmall' => [979, 3]
    ]
]);
?>


<div class="item-class"><img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/landing/1.jpg' ?>"
                             alt="Image 1"></div>
<div class="item-class"><img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/landing/2.jpg' ?>"
                             alt="Image 2"></div>
<div class="item-class"><img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/landing/3.jpg' ?>"
                             alt="Image 3"></div>
<div class="item-class"><img src="<?= \Yii::$app->params['staticHostInfo'] . '/files/images/landing/4.jpg' ?>"
                             alt="Image 4"></div>
<?php OwlCarouselWidget::end(); ?>
<span>На отдых в Калининград</span>
<section class="landing-block-center">
    <div style="width: 1200px !important;">
        <h2>Для гостей</h2>
    </div>
</section>

<div>
    <div id="nb_events">
        <script id="nbEventsScript" type="text/javascript"  src="http://widget.nbcrs.org/Js/Widget/loader.js?key=aa3ea4347e024444b40b50157ddef198&subKey=39930838">
        </script></div>
</div>


<div>
    Отзывы
</div>

<div>
    О нас, возможно ...
</div>
Вас здесь не должно быть ... пока-что ;)