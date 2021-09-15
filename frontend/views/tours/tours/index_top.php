<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchTourForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\booking\tours\ReviewTour;
use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use booking\helpers\Emoji;
use frontend\widgets\templates\GuidesObjectWidget;
use frontend\widgets\templates\HelperWidget;
use frontend\widgets\templates\ReviewObjectWidget;
use frontend\widgets\templates\TagsWidget;
use yii\data\DataProviderInterface;

$this->title = Lang::t('Экскурсии по Калининграду обзорная, замки, форты - недорого');
$this->params['emoji'] = Emoji::TOUR;
?>

<div class="list-tours">
    <h1><?= Lang::t('Экскурсии по Калининграду и области') ?></h1>
    <?= $this->render('_search_top', ['model' => $model]) ?>
    <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
    <!--Отзывы туристов-->
    <?= ReviewObjectWidget::widget([
            'object' => ReviewTour::class
    ]) ?>

    <!--Как забронировать экскурсию-->
    <?= HelperWidget::widget([
        'title' => 'Как заказать экскурсию',
        'youtube' => 'https://www.youtube.com/watch?v=TmR-pO6JT60',
        'link' => 'https://koenigs.ru/help-tour',
    ]) ?>

    <!--Облако тегов-->
    <?= TagsWidget::widget([
        'object' => Tour::class
    ]) ?>
    <!--Наши гиды-->
    <?= GuidesObjectWidget::widget([
        'object' => Tour::class
    ]) ?>

</div>
