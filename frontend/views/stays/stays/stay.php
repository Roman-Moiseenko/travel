<?php

use booking\entities\booking\stays\CustomServices;
use booking\entities\booking\stays\nearby\NearbyCategory;
use booking\entities\booking\stays\rules\CheckIn;
use booking\entities\booking\stays\rules\Parking;
use booking\entities\booking\stays\rules\Rules;
use booking\entities\booking\stays\rules\WiFi;
use booking\entities\booking\stays\Stay;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;
use booking\helpers\stays\StayHelper;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\assets\MapStayAsset;
use frontend\widgets\GalleryWidget;
use frontend\widgets\LegalWidget;
use frontend\widgets\reviews\NewReviewFunWidget;
use frontend\widgets\reviews\NewReviewStayWidget;
use frontend\widgets\reviews\ReviewsWidget;
use kartik\widgets\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $stay Stay */
/* @var $SearchStayForm array */
/* @var $openMap bool */

$layout = <<< HTML
<div class="row">
    <div class="col">
        <div class="form-group">
            <label class="mb-0" for="searchstayform-date_from">Дата заезда</label>
            {input1}
        </div>
    </div>
</div>
<div class="row">
    <div class="col">   
        <div class="form-group">    
            <label class="mb-0" for="searchstayform-date_to">Дата отъезда</label>
            {input2}
        </div>
    </div>
</div>
HTML;

$_not_date = Stay::ERROR_NOT_DATE;
$_not_free = Stay::ERROR_NOT_FREE;
$_not_child = Stay::ERROR_NOT_CHILD;
$_not_date_end = Stay::ERROR_NOT_DATE_END;
$_arr_error = Stay::listErrors();
$_count_service = count($stay->services);
$js = <<<JS
$(document).ready(function() {
    let stay_id;
    let begin_date;
    let end_date;
    let guest;
    let children;
    let children_age = new Array(8);
    
    update_fields();
    update_data();
    $('body').on('change', '#children', function () {
        update_fields();
        update_data();
    });    
    $('body').on('click', '.click-field-stay-params', function() {
       update_data();        
    });
    $('body').on('change', '.change-field-stay-params', function() {
        update_data();       
    });

    function update_data() {
        stay_id = $('#stay-id').data('id');
        begin_date = $('#begin-date').val();
        end_date = $('#end-date').val();
        guest = $('#guest').val();
        children = $('#children').val();
        children_age = new Array();
        
        $('#data-stay').attr('data-date-from', begin_date);
        $('#data-stay').attr('data-date-to', end_date);
        $('#data-stay').attr('data-guest', guest);
        $('#data-stay').attr('data-children', children);
        
        for (let i = 0; i < 8; i++) {
            children_age[i] = $('#children-age-' + i).val();
            $('#data-stay').attr('data-children-age' + i, children_age[i]);
        }
        
        let _services = new Array();
        for (let j = 0; j < $_count_service; j++) {
            if ($('#service-' + j).is(':checked')) _services[j] = $('#service-' + j).data('id');
        }
        $.post('/stays/stays/get-booking', 
        {stay_id: stay_id, date_from: begin_date, date_to: end_date, guest: guest, children: children, children_age: children_age, services: _services}, 
        function(data) {
            let _result = JSON.parse(data);
            if (_result.error != 0) {
                $('.new-booking').hide();
                $('#error-booking').html(_result.error);
                $('#amount-booking').html('');
                $('#amount-prepay').html('');
            } else {
                $('#error-booking').html('');
                $('.new-booking').show();
                $('#map-stay').attr('data-cost', _result.cost);
                $('#amount-booking').html(_result.cost);
                $('#amount-prepay').html(_result.prepay);
                $('#amount-percent').html(_result.percent);
            }
        });
    }
    
    function update_fields() {
        let _count = $('#children').val();
        for (let i = 0; i < 8; i++) {
            if (i < _count) {
                $('#children_age-' + i).show();
            } else {
                $('#children_age-' + i).hide();
                $('#children-age-' + i).val('');
            }
        }
    }

});
JS;
$this->registerJs($js);

$_city = $SearchStayForm;
$_city['city'] = $stay->city;
$this->registerMetaTag(['name' => 'description', 'content' => $stay->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $stay->meta->description]);

$this->title = $stay->meta->title ? Lang::t($stay->meta->title) : $stay->getName();
$this->params['canonical'] = Url::to(['/stay/view', 'id' => $stay->id], true);

$this->params['breadcrumbs'][] = ['label' => Lang::t('Все апартаменты'), 'url' => Url::to(['stays/index', 'SearchStayForm' => $SearchStayForm])];
$this->params['breadcrumbs'][] = ['label' => Lang::t($stay->city), 'url' => Url::to(['stays/index', 'SearchStayForm' => $_city])];
$this->params['breadcrumbs'][] = $stay->getName();

MagnificPopupAsset::register($this);
MapStayAsset::register($this);

//Клик по карте
if ($openMap) {
    $url = Url::current(['map' => null]);
    $js_click = <<<JS
$(document).ready(function() {
    $('#a-map-stay').click();

$('.fancybox-close').click(function(e){
    e.preventDefault();
    history.pushState({}, '', '$url');
    });
});
JS;
    $this->registerJs($js_click);
}
$mobile = SysHelper::isMobile();
$countReveiws = $stay->countReviews();

?>
    <span id="ymap-params" data-api="<?= \Yii::$app->params['YandexAPI'] ?>"
          data-lang="<?= Lang::current() == 'ru' ? 'ru_RU' : 'en_US' ?>"></span>
<?=
newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => false,
    'mouse' => true,
    'config' => [
        'maxWidth' => '95%',
        'maxHeight' => '95%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '90%',
        'height' => '90%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'none',
        'closeEffect' => 'none',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => true,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'inline'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.3)'
                ]
            ]
        ],
    ]
]);
?>
    <span id="data-stay"
         data-id="<?= $stay->id ?>"
         data-date-from="<?= $SearchStayForm['date_from']?>"
         data-date-to="<?= $SearchStayForm['date_to']?>"
         data-guest="<?= $SearchStayForm['guest']?>"
         data-children="<?= $SearchStayForm['children']?>"
         data-children-age0="<?= $SearchStayForm['children_age'][0]?>"
         data-children-age1="<?= $SearchStayForm['children_age'][1]?>"
         data-children-age2="<?= $SearchStayForm['children_age'][2]?>"
         data-children-age3="<?= $SearchStayForm['children_age'][3]?>"
         data-children-age4="<?= $SearchStayForm['children_age'][4]?>"
         data-children-age5="<?= $SearchStayForm['children_age'][5]?>"
         data-children-age6="<?= $SearchStayForm['children_age'][6]?>"
         data-children-age7="<?= $SearchStayForm['children_age'][7]?>"
    ></span>
    <span id="stay-id" data-id="<?= $stay->id ?>"></span>
    <!-- ФОТО  -->
    <div class="pb-4 thumbnails gallery" style="margin-left: 0 !important;"
         xmlns:fb="https://www.w3.org/1999/xhtml" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <?php foreach ($stay->photos as $i => $photo) {
            echo GalleryWidget::widget([
                'photo' => $photo,
                'iterator' => $i,
                'count' => count($stay->photos),
                'name' => $stay->getName(),
                'description' => $stay->description,
            ]);
        } ?>
    </div>
    <!-- ОПИСАНИЕ -->
    <div class="row pt-2" <?= $mobile ? ' style="width: 100vw"' : '' ?>>
        <div class="col-sm-12 <?= $mobile ? ' ml-2' : '' ?>">
            <!-- Заголовок Развлечения-->
            <div class="row pb-3">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h1><?= Html::encode($stay->getName()) ?></h1>
                        </div>
                        <div class="btn-group">
                            <button type="button" data-toggle="tooltip" class="btn btn-info btn-wish"
                                    title="<?= Lang::t('В избранное') ?>"
                                    href="<?= Url::to(['/cabinet/wishlist/add-stay', 'id' => $stay->id]) ?>"
                                    data-method="post">
                                <i class="fa fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-12">
                    <a href="#map-stay" id="a-map-stay" title="" rel="fancybox" class="loader_ymap">
                        <i class="fas fa-map-marker-alt"></i> <?= $stay->address->address ?>

                    </a>
                    <div id="map-stay"
                         data-zoom="16"
                         data-longitude="<?= $stay->address->longitude ?>"
                         data-latitude="<?= $stay->address->latitude ?>"
                         data-name="<?= $stay->getName() ?>"
                         data-cost="<?= ($cost = $stay->costBySearchParams($SearchStayForm)) < 0 ? '' : CurrencyHelper::stat($cost)?>"
                         style="display: none; height: 100%;"
                    ></div>
                </div>
            </div>
            <!-- Описание -->
            <div class="row">
                <div class="col-sm-8 params-tour text-justify">
                    <?= Yii::$app->formatter->asHtml($stay->getDescription(), [
                        'Attr.AllowedRel' => array('nofollow'),
                        'HTML.SafeObject' => true,
                        'Output.FlashCompat' => true,
                        'HTML.SafeIframe' => true,
                        'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    ]) ?>
                    <div>
                        <p>
                            <?= Lang::t('К Вашим услугам') . ' ' . StayHelper::textRooms($stay) .
                            ' ' . Lang::t('с') . ' ' . StayHelper::textBeds($stay, false) . ', ' .
                            Lang::t('где могут расположиться') . ' ' . $stay->params->guest . ' ' . Lang::t('гостей') . '.';
                            ?></p>
                        <p>
                            <?= Lang::t('Общая площадь помещения ') . $stay->params->square . Lang::t(' кв.м.') . Lang::t(' В доме ') . $stay->params->count_floor . Lang::t(' этажей') . '.' ?></p>
                        <p>
                            <?php if ($stay->params->count_kitchen == 0 && $stay->params->count_bath == 0): ?>
                                <?= Lang::t('Ванная комната и кухня не предусмотрены в жилом помещении.') ?>
                            <?php else: ?>
                                <?= ($stay->params->count_kitchen > 0)
                                    ? Lang::t('К распоряжению гостей имеется ') . StayHelper::textKitchen($stay->params->count_kitchen) . (
                                    ($stay->params->count_bath > 0) ? Lang::t(', а также, ') . StayHelper::textBath($stay->params->count_bath) . '.' : '. Ванная комната отсутствует.'
                                    )
                                    : Lang::t('Кухня не предусмотрена. ') . (
                                    ($stay->params->count_bath > 0) ? Lang::t('К распоряжению гостей имеется ') . StayHelper::textBath($stay->params->count_bath) . '.' : '<==>'
                                    ) ?>
                            <?php endif; ?>
                        </p>
                        <p></p>
                        <p><?= Lang::t('Что поблизости') ?>:<br>
                            <?php foreach ($stay->getNearbySortCategory() as $group => $category): ?>
                                <?php foreach ($category as $name_category => $nearby_list): ?>
                                    <?= $name_category ?>
                                    <?php $n = count($nearby_list); ?>
                                    <?php foreach ($nearby_list as $i => $nearby): ?>
                                        <?= $nearby['name'] . ' на расстоянии ' . $nearby['distance'] . ' ' . $nearby['unit'] . (($n == $i + 1) ? '.' : ', '); ?>
                                    <?php endforeach; ?>
                                    <br>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </p>
                    </div>
                </div>

                <div class="col-sm-4">
                    <?= LegalWidget::widget(['legal' => $stay->legal]) ?>
                </div>
            </div>
            <!-- БРОНЬ -->
            <?= Html::beginForm(['stays/checkout/booking']); ?>
            <input type="hidden" name="SearchStayForm[stay_id]" value="<?= $stay->id ?>">
            <div class="leftbar-search-stays">
                <?php if ($mobile) {
                    echo '<div>';
                } else {
                    echo '<table width="100%"><tr><td class="p-2" width="263px">';
                }?>

                            <?php $form = ActiveForm::begin([
                                'id' => 'search-stay-form',
                                'action' => '/' . Lang::current() . '/stay/',
                                'method' => 'GET',
                                'enableClientValidation' => false,
                            ]) ?>
                            <div class="not-flex">
                                <?= DatePicker::widget([
                                    'id' => 'stay-range',
                                    'model' => $model,
                                    'attribute' => 'date_from',
                                    'attribute2' => 'date_to',
                                    'type' => DatePicker::TYPE_RANGE,
                                    'layout' => $layout,
                                    'separator' => '',
                                    'size' => 'lg',
                                    'options' => ['class' => 'form-control form-control-xl change-field-stay-params', 'readonly' => 'readonly', 'style' => 'text-align: left;', 'id' => 'begin-date'],
                                    'options2' => ['class' => 'form-control form-control-xl change-field-stay-params', 'readonly' => 'readonly', 'style' => 'text-align: left;', 'id' => 'end-date'],
                                    'language' => Lang::current(),
                                    'pluginOptions' => [
                                        'startDate' => '+1d',
                                        'todayHighLight' => true,
                                        'autoclose' => true,
                                        'format' => 'DD, dd MM yyyy',
                                    ],
                                    'pluginEvents' =>  [
                                        'changeDate' => "function(e) {       
                                            if (e.target.id == 'begin-date') {sessionStorage.setItem('date_to', e.date);}
                                            if (e.target.id == 'end-date') {sessionStorage.setItem('date_from', e.date);}
                                            let _date_to = sessionStorage.getItem('date_to');
                                            let _date_from = sessionStorage.getItem('date_from'); 
                                            if (_date_to !== null && _date_from !== null) {
                                                if (_date_to === _date_from) {
                                                    let _date = e.date;
                                                    _date.setDate(_date.getDate() + 1)
                                                    $('#end-date').kvDatepicker('update', _date);
                                                    sessionStorage.setItem('date_from', _date);
                                    }                                   
                                }                             
                            }",
                                    ],
                                ]) ?>
                            </div>
                            <div class="d-flex">
                                <div class="mr-auto">
                                    <?= $form->field($model, 'guest')
                                        ->dropDownList(StayHelper::listGuest($stay->params->guest), ['class' => 'form-control form-control-xl change-field-stay-params', 'id' => 'guest'])
                                        ->label(false); ?>
                                </div>
                                <?= $form->field($model, 'children')
                                    ->dropDownList(StayHelper::listChildren(), ['class' => 'form-control form-control-xl ml-1 change-field-stay-params', 'id' => 'children'])
                                    ->label(false); ?>
                            </div>
                            <div class="search-stay-not-margin">
                                <?php for ($i = 0; $i < 8; $i++): ?>
                                    <span id="children_age-<?= $i ?>" style="display: none">
                                        <?= $form
                                            ->field($model, 'children_age[' . $i . ']')
                                            ->dropdownList(StayHelper::listAge(), ['prompt' => 'Возраст ребенка', 'class' => 'form-control form-control-xl change-field-stay-params', 'id' => 'children-age-' . $i])
                                            ->label(false); ?>
                                     </span>
                                <?php endfor; ?>
                            </div>
                            <span style="font-weight: 600; color: #212121">* <?= Lang::t('бронирование от ') . $stay->min_rent . Lang::t(' суток')?></span>
                            <?php ActiveForm::end(); ?>
                <?php if ($mobile) {
                    echo '</div><div>';
                } else {
                    echo '</td><td class="p-2" valign="top">';
                }?>

                            <?php if (count($stay->services) > 0) {
                                echo '<b>' . Lang::t('Выберите дополнительные услуги') . ':</b>';
                            } ?>
                            <?php foreach ($stay->services as $i => $service): ?>
                                <div class="custom-control custom-checkbox">

                                    <input type="checkbox" class="custom-control-input click-field-stay-params"
                                           id="service-<?= $i ?>" data-id="<?= $service->id; ?>" name="SearchStayForm[service][<?= $i ?>]" value="<?= $service->id ?>">
                                    <label class="custom-control-label"
                                           for="service-<?= $i ?>"><?= $service->name . ' (' . $service->value . ' ' . CustomServices::listPayment()[$service->payment] . ')' ?> </label>
                                </div>
                            <?php endforeach; ?>
                <?php if ($mobile) {
                    echo '</div><div>';
                } else {
                    echo '</td><td class="p-2" width="320px" valign="top" style="border-left: #575757 solid 1px">';
                }?>

                            <div class="mb-auto" style="align-items: center; text-align: center; display: inline-flex;">
                                <span class="py-2 my-2" id="amount-booking" style="color: #122b40; font-size: 48px; font-weight: 800"></span>
                            </div>
                            <div class="form-group pt-2">
                                <div class="d2-btn-box">
                                    <button class="d2-btn d2-btn-lg d2-btn-block d2-btn-main new-booking" type="submit" id="new-booking">
                                        <div class="d2-btn-caption"><?= Lang::t('Забронировать') ?></div>
                                        <div class="d2-btn-icon">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <span class="new-booking" style="font-size: 24px; color: #0a0a0a; display: none;">
                                    <?= Lang::t('предоплата') ?> (<span id="amount-percent"></span>%):
                                </span><br>
                                <span class="py-2 my-2 d2-badge d2-badge-success" id="amount-prepay" style="font-size: 38px; font-weight: 800"></span>
                            </div>
                            <div id="error-booking" style="color: #530000; font-weight: 600; font-size: 16px;">
                            </div>
                <?php if ($mobile) {
                    echo '</div>';
                } else {
                    echo '</td></tr></table>';
                }?>

            </div>
            <?= Html::endForm() ?>
            <!-- УДОБСТВА -->
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Удобства') ?></div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?php $n = 0;
                    foreach ($stay->getComfortsSortCategory() as $i => $category): ?>
                        <b><span style="color: green"><i class="<?= $category['image'] ?>"></i> <?= $category['name'] ?></span></b>
                        <?php foreach ($category['items'] as $comfort): ?>
                            <?php $n++; ?>
                            <div>
                                <?= '&#10004;' . ' ' . $comfort['name'] . ' ' . ($comfort['pay'] == null ? '' : ($comfort['pay'] == true ? '<span class="badge badge-danger">платно</span>' : '<span class="badge badge-success">free</span>')) ?>
                                <?php if ($comfort['photo'] != ''): ?>
                                    <a class="up-image" href="#"><i class="fas fa-camera"
                                                                    style="color: #0c525d; font-size: 20px;"></i><span><img
                                                    src="<?= $comfort['photo'] ?>" alt=""></span></a>
                                <?php endif; ?>
                            </div>
                            <?php if ($n == round(count($stay->assignComforts) / 3) || $n == 2 * round(count($stay->assignComforts) / 3)) {
                                echo '</div><div class="col-sm-4">';
                            } ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- УДОБСТВА В КОМНАТАХ -->
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Удобства в номере') ?></div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php $m = 0;
                    $categories = $stay->getComfortsRoomSortCategoryFrontend();
                    $count = count($stay->assignComfortsRoom) + count($categories);
                    foreach ($categories as $i => $category): ?>
                        <?php $m++ ?>
                        <b><i class="<?= $category['image'] ?>"></i> <?= $category['name'] ?></b>
                        <?php if ($m == round($count / 4) || $m == round($count / 2) || $m == 3 * round($count / 4)) {
                            echo '</div><div class="col-sm-3">';
                        } ?>
                        <?php foreach ($category['items'] as $comfort): ?>

                            <?php $m++ ?>
                            <div>
                                <?= $comfort['name'] ?>
                                <?php if ($comfort['photo'] != ''): ?>
                                    <a class="up-image" href="#"><i class="fas fa-camera"
                                                                    style="color: #0c525d; font-size: 20px;"></i>
                                        <span><img src="<?= $comfort['photo'] ?>" alt=""></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php if ($m == round($count / 4) || $m == round($count / 2) || $m == 3 * round($count / 4)) {
                                echo '</div><div class="col-sm-3">';
                            } ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <hr/>
            <!-- ПРАВИЛА ПРОЖИВАНИЯ -->
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Правила проживания') ?></div>
            </div>
            <div class="row">
                <div class="col">
                    <!-- ************************************************************************************************************************************ -->

                    <div class="card">
                        <div class="card-body"
                             style="font-size: 14px; background-color: rgba(42,171,210,0.54); color: black">
                            <table width="100%">
                                <tr>
                                    <td width="20px">
                                        <i class="fas fa-bed" style="font-size: 20px !important;"></i>
                                    </td>
                                    <td class="pl-4">
                                        <?php if ($stay->rules->beds->child_on): ?>
                                            <b>Допускается установка дополнительных детских кроватей с 0
                                                до <?= $stay->rules->beds->child_agelimit ?>:</b><br>
                                            - Установка дополнительной детской кровати <?= (int)$stay->rules->beds->child_cost == 0 ? Lang::t('бесплатна') : $stay->rules->beds->child_cost . ' ' . Lang::t('руб/сут') ?>
                                            <br>
                                            - Допускается установка не более <?= $stay->rules->beds->child_count ?> кроватей
                                            <br>
                                        <?php else: ?>
                                            Установка дополнительных детских кроватей не допускается<br>
                                        <?php endif; ?>
                                        <b>Ребенок считается взрослым для размещения на отдельной кровати
                                            с <?= $stay->rules->beds->child_by_adult ?> лет</b><br>
                                        <?php if ($stay->rules->beds->adult_on): ?>
                                            <b>Допускается установка дополнительных кроватей:</b><br>
                                            - Установка дополнительной кровати <?= (int)$stay->rules->beds->adult_cost == 0 ? Lang::t('бесплатна') : $stay->rules->beds->adult_cost . ' ' . Lang::t('руб/сут') ?>
                                            <br>
                                            - Допускается установка не более <?= $stay->rules->beds->adult_count ?> кроватей
                                            <br>
                                        <?php else: ?>
                                            Установка дополнительных кроватей не допускается<br>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&#160;</td>
                                </tr>
                                <tr>
                                    <td width="20px">
                                        <i class="fas fa-parking" style="font-size: 20px !important;"></i>
                                    </td>
                                    <td class="pl-4">
                                        <?php if ($stay->rules->parking->is()): ?>
                                            Гостям предоставляется <?= Parking::listPrivate()[$stay->rules->parking->private] ?>
                                            парковка <?= Parking::listInside()[$stay->rules->parking->inside] ?>
                                            <br>
                                            <?= $stay->rules->parking->reserve ? 'Необходимо предварительно бронировать<br>' : '' ?>
                                            <?= $stay->rules->parking->security ? 'Парковка охраняется<br>' : '' ?>
                                            <?= $stay->rules->parking->covered ? 'Парковка имеет укрытие от осадков<br>' : '' ?>
                                            <?= $stay->rules->parking->street ? 'Парковка расположена на улице' : 'Парковка расположена в здании' ?>
                                            <br>
                                            <?= $stay->rules->parking->invalid ? 'Имеются места для людей с физическими ограничениями<br>' : '' ?>
                                            <?= (int)$stay->rules->parking->status == Rules::STATUS_PAY ? 'Стоимость парковки за ' . Parking::listCost()[$stay->rules->parking->cost_type] . ' ' . $stay->rules->parking->cost . ' руб.' : '' ?>

                                        <?php else: ?>
                                            Парковка не предусмотрена<br>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&#160;</td>
                                </tr>
                                <tr>
                                    <td width="20px">
                                        <i class="fas fa-clock" style="font-size: 20px !important;"></i>
                                    </td>
                                    <td class="pl-4">
                                        Заезд гостей возможен
                                        с <?= CheckIn::string_time($stay->rules->checkin->checkin_from) ?>
                                        до <?= CheckIn::string_time($stay->rules->checkin->checkin_to) ?><br>
                                        Отъезд гостей возможен
                                        с <?= CheckIn::string_time($stay->rules->checkin->checkout_from) ?>
                                        до <?= CheckIn::string_time($stay->rules->checkin->checkout_to) ?><br>
                                        <?= $stay->rules->checkin->message ? 'Гостям необходимо предварительно сообщить время заезда' : '' ?>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&#160;</td>
                                </tr>
                                <tr>
                                    <td width="20px">
                                        <i class="fas fa-smoking-ban" style="font-size: 20px !important;"></i>
                                    </td>
                                    <td class="pl-4">
                                        <?= $stay->rules->limit->smoking ? Lang::t('Разрешается курение в номерах') : Lang::t('Курение в номерах запрещено') ?>
                                        <br>
                                        Размещение с животными <?=
                                        !$stay->rules->limit->isAnimals() ?
                                            'не разрешено' :
                                            ($stay->rules->limit->animals == Rules::STATUS_FREE ?
                                                'разрешено' :
                                                'платно')
                                        ?><br>
                                        <?= $stay->rules->limit->children ? 'Разрешено с детьми с ' . $stay->rules->limit->children_allow . ' лет' : 'Заселение с детьми не разрешено!' ?>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&#160;</td>
                                </tr>
                                <tr>
                                    <td width="20px">
                                        <i class="fas fa-wifi" style="font-size: 20px !important;"></i>
                                    </td>
                                    <td class="pl-4">
                                        <?= $stay->rules->wifi->is()
                                            ? 'WiFi действует ' . WiFi::listArea()[$stay->rules->wifi->area] . '. Пользование WiFi ' .
                                            ($stay->rules->wifi->free()
                                                ? 'бесплатно'
                                                : 'платно, цена ' .
                                                $stay->rules->wifi->cost . ' руб. за ' .
                                                WiFi::listCost()[$stay->rules->wifi->cost_type])
                                            : 'WiFi отсутствует' ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- ************************************************************************************************************************************ -->
                </div>
            </div>

            <!-- ОТЗЫВЫ -->
            <!-- Виджет подгрузки отзывов -->
            <div class="container-hr">
                <hr/>
                <div class="text-left-hr"><?= Lang::t('Отзывы') . ' (' . $countReveiws . ')' ?></div>
            </div>
            <div id="review">
                <?= ReviewsWidget::widget(['reviews' => $stay->reviews]); ?>
            </div>
            <?= NewReviewStayWidget::widget(['stay_id' => $stay->id]); ?>
        </div>
    </div>
    <div itemtype="https://schema.org/Offer" itemscope>
        <meta itemprop="name" content="<?= $stay->getName() ?>" />
        <meta itemprop="description" content="<?= Lang::t('Бронирование жилья') ?>" />
        <meta itemprop="price" content="<?= $stay->cost_base ?>" />
        <meta itemprop="priceCurrency" content="RUB" />
        <link itemprop="url" href="<?= Url::to(['/stay/view', 'id' => $stay->id], true) ?>" />
        <div itemprop="eligibleRegion" itemtype="https://schema.org/Country" itemscope>
            <meta itemprop="name" content="Russia, Kaliningrad" />
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
            </div>
        </div>
        <div itemprop="offeredBy" itemtype="https://schema.org/Organization" itemscope>
            <meta itemprop="name" content="<?= $stay->legal->caption ?>" />
            <link itemprop="url" href="<?= Url::to(['legals/view', 'id' => $stay->legal->id], true) ?>" />
            <meta itemprop="telephone" content="<?= \Yii::$app->params['supportPhone'] ?>">
            <div itemprop="address" itemscope="" itemtype="https://schema.org/PostalAddress">
                <meta itemprop="streetAddress" content="<?= \Yii::$app->params['address']['streetAddress'] ?>">
                <meta itemprop="postalCode" content="<?= \Yii::$app->params['address']['postalCode'] ?>">
                <meta itemprop="addressLocality" content="<?= \Yii::$app->params['address']['addressLocality'] ?>">
            </div>
        </div>
    </div>
<?php $js = <<<EOD
    $(document).ready(function() {
        $('.thumbnails').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js);

?>