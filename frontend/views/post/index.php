<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $category Category */

use booking\entities\blog\Category;
use booking\entities\Lang;
use yii\helpers\Html;

$this->title = Lang::t('Блог');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>