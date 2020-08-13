<?php

use booking\entities\booking\tours\Tours;
use booking\forms\booking\ReviewForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $tour Tours */

/* @var $reviewForm ReviewForm */

use booking\helpers\CurrencyHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\widgets\RatingWidget;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $tour->name;
$this->params['breadcrumbs'][] = ['label' => 'Список туров', 'url' => Url::to(['tours/index'])];
$this->params['breadcrumbs'][] = $this->title;

MagnificPopupAsset::register($this);
$countReveiws = $tour->countReviews();
?>
<!-- ФОТО  -->
<div class="row" xmlns:fb="http://www.w3.org/1999/xhtml">
    <div class="col">
        <ul class="thumbnails">
            <?php foreach ($tour->photos as $i => $photo): ?>
                <?php if ($i == 0): ?>
                    <li>
                        <a class="thumbnail" href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                            <img src="<?= $photo->getThumbFileUrl('file', 'catalog_tours_main'); ?>"
                                 alt="<?= Html::encode($tour->name); ?>"/>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="image-additional">
                        <a class="thumbnail" href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>">&nbsp;
                            <img src="<?= $photo->getThumbFileUrl('file', 'catalog_tours_additional'); ?>"
                                 alt="<?= $tour->name; ?>"/>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- ОПИСАНИЕ -->
<div class="row">
    <div class="col-8">
        <div class="row">
            <h1><?= Html::encode($tour->name) ?></h1> <!-- Заголовок тура-->
            <div class="col-8">
                <?= \Yii::$app->formatter->asNtext($tour->description) ?>
            </div>
            <div class="col-4">
                Виджет с лого Компании <?= $tour->legal->name;?>
            </div>
        </div>
        <!-- Параметры -->
        <div class="row pt-4">
            <div class="col">
                ________________________<br>
                Продолжительность
                Индивид/Групп
                Категории
                Кол-во в группе
                Ограничения по возрасту
                ? Отмена бронирования<br>
                ________________________
            </div>
        </div>
        <!-- Дополнения -->
        <div class="row pt-4">
            <div class="col">
                <h3>Дополнительно:</h3>
                <table class="table table-bordered">
                    <tbody>
                    <?php foreach ($tour->extra as $extra): ?>
                        <?php if (!empty($extra->name)): ?>
                            <tr>
                                <th><?= Html::encode($extra->name) ?></th>
                                <td><?= Html::encode($extra->description) ?></td>
                                <td><?= Html::encode(CurrencyHelper::get($extra->cost)) ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Координаты -->
        <div class="row pt-4">
            <div class="col">
                <h3>Координаты</h3>
                Место сбора: Адрес + КАРТА<br>
                Место окончания: Адрес<br>
                Если Проведение != Сбора => Место проведения: Адрес
            </div>
        </div>
        <!-- ОТЗЫВЫ -->
        <div class="row">
            <div class="col">
                <!-- Виджет подгрузки отзывов -->
                <h3>Отзывы (<?= $countReveiws ?>)</h3>
                <?= ''// ReviewsWidget::widget(['tours' => $tour]);     ?>

                <div id="review"></div>
                <h2>Оставить отзыв</h2>
                <?php if (Yii::$app->user->isGuest): ?>
                    <div class="card">
                        <div class="card-body">
                            Пожалуйста, <?= Html::a('авторизуйтесь', ['/auth/auth/login']) ?> для написания отзыва
                        </div>
                    </div>
                <?php else: ?>
                    <?php $form = ActiveForm::begin() ?>
                    <?= $form->field($reviewForm, 'vote')->dropDownList($reviewForm->voteList(), ['prompt' => '--- Выберите ---'])->label('Рейтинг'); ?>

                    <?= $form->field($reviewForm, 'text')->textarea(['rows' => 5])->label('Отзыв'); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <!-- КУПИТЬ БИЛЕТЫ -->
    <div class="col-4">
        <div class="btn-group">
            <button type="button" data-toggle="tooltip" class="btn btn-default" title="В избранное"
                    href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $tour->id]) ?>" data-method="post">
                <i class="fa fa-heart"></i>
            </button>
            <!-- button type="button" data-toggle="tooltip" class="btn btn-default" title="Сравнить" onclick="compare.add('47');">
                <i class="fa fa-exchange"></i>
            </button -->
        </div>
        <div id="buy-tour" class="required">
            <hr>
            <h3>Приобрести билеты на тур</h3>
            <?= Html::beginForm(['/shop/cart/add', 'id' => $tour->id]); ?>
            <label class="control-label" for="quantity-product-to-cart">Кол-во</label>
            ДАТА (Календарь выпадающий с датами доступными только), ВРЕМЯ (список из Календаря),
            КОЛ-ВО оставшихся билетов, ЦЕНА по категориям, ПОЛЯ ввода Кол-ва билетов каждой категории
            <input id="quantity-product-to-cart" type="text" name="quantity" value="1" size="1" class="form-control"
                   required/>
            <p></p>
            <div class="form-group">
                <?= Html::submitButton('Приобрести', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
            </div>
            <?= Html::endForm() ?>
        </div>
        <div class="rating">
            <p>
                <?= RatingWidget::widget(['rating' => $tour->rating]); ?>
                <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">
                    <?= $countReveiws ?> отзывов</a>
                &nbsp;/&nbsp;<a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">Написать
                    отзыв</a>
            </p>
            <hr>

            <div class="addthis_toolbox addthis_default_style"
                 data-url="https://demo.opencart.com/index.php?route=product/product&amp;product_id=47">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count">
                </a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a>
                <a class="addthis_counter addthis_pill_style"></a></div>
            <script type="text/javascript"
                    src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>

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
$this->registerJs($js); ?>
