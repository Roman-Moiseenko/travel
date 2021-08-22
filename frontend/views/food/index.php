<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchFoodForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\tours\SearchTourForm;
use booking\forms\foods\SearchFoodForm;
use booking\helpers\Emoji;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Lang::t('Где поесть в Калининграде - рестораны, кафе, доставка');
$description = 'Рестораны Калининграда где недорого и вкусно поесть кафе, пиццерии, кофейни, морепродукты, попить кофес круассанами, заказать пиво в пабе и баре, перекусить суши';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
$this->params['canonical'] = Url::to(['/foods'], true);
$this->params['emoji'] = Emoji::FOOD;
?>

<div class="list-tours">
    <h1><?= Lang::t('Где поесть в Калининграде и области') ?></h1>
    <?= $this->render('_search', ['model' => $model]) ?>
    <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
</div>
