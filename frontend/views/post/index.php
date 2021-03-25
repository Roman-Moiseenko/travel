<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category Category */

use booking\entities\blog\Category;
use booking\entities\Lang;
use yii\helpers\Html;
$this->registerMetaTag(['name' =>'description', 'content' => 'Цикл статей о Калининграде и Калининградской области. Достопримечательности, города, увлечения, природа.']);
$this->title = Lang::t('О Калининградской области подробно');
$this->params['breadcrumbs'][] = Lang::t('О Калининградской области');
?>

<h1><?= Lang::t('О Калининградской области'); ?></h1>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>