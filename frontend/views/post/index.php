<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category Category */

use booking\entities\blog\Category;
use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

$description = 'Стати о Калининграде, об истории, обзорный материал, история Кёнигсберга. Достопримечательности, города, увлечения, природа, замки и форты Кенигсберга и о путешествии в Калининград';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
$this->params['canonical'] = Url::to(['/post'], true);
$this->title = Lang::t('О Калининградской области подробно');
$this->params['breadcrumbs'][] = Lang::t('О Калининградской области');
?>

<h1><?= Lang::t('О Калининградской области'); ?></h1>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>