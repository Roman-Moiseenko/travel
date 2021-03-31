<?php

use booking\entities\Lang;
use booking\forms\foods\SearchFoodForm;
use booking\helpers\FoodHelper;
use frontend\assets\MapFoodsAsset;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model SearchFoodForm */

$current = \Yii::$app->request->get('sort') ?? '';
$up = Lang::t('По возрастанию');
$down = Lang::t('По убыванию');
$values = [
    '' => Lang::t('по умолчанию'),
    'name' => Lang::t('по имени (А-Я)'),
    '-rating' => Lang::t('по рейтингу (сначала высокий)'),
];
MapFoodsAsset::register($this);
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

<div id="map-foods"
     data-zoom="16"
     style="display: none; height: 100%;"
></div>

<?php $form = ActiveForm::begin([
    'method' => 'GET',
    'action' => '/foods',
    'enableClientValidation' => false,
]) ?>
<div class="topbar-search-foods">
    <div class="row">
        <div class="col-md-3 col-sm-4">
            <?= $form
                ->field($model, 'kitchen_id')
                ->dropDownList(Lang::a(FoodHelper::listKitchen()), ['prompt' => '-- Кухня --', 'onchange' => 'submit()'])
                ->label(false); ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <?= $form
                ->field($model, 'category_id')
                ->dropDownList(Lang::a(FoodHelper::listCategory()), ['prompt' => '-- Заведение --', 'onchange' => 'submit()'])
                ->label(false); ?>
        </div>
        <div class="col-md-2 col-sm-4">
            <?= $form
                ->field($model, 'city')
                ->dropDownList(Lang::a(FoodHelper::listCity()), ['prompt' => '-- Город --', 'onchange' => 'submit()'])
                ->label(false); ?>
        </div>
        <div class="col-sm-2">
                <?= Html::a(Lang::t('Показать карту'),'#map-foods', ['class' => 'btn btn-map loader_ymap', 'rel' => 'fancybox']) ?>
        </div>
        <div class="col-sm-2">
            <select id="input-sort" class="form-control" onchange="location = this.value;">
                <?php foreach ($values as $value => $label): ?>
                    <option value="<?= Html::encode(Url::current(['sort' => $value ?: null])) ?>"
                            <?php if ($value === $current): ?>selected="selected"<?php endif; ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
