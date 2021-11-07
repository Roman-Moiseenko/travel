<?php

use booking\entities\touristic\fun\Category;
use booking\helpers\Emoji;
use booking\helpers\SysHelper;
use frontend\assets\MagnificPopupAsset;
use frontend\assets\MapAsset;
use frontend\widgets\info\NewProviderWidget;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $dataProvider null */
/* @var $category Category */
$this->registerMetaTag(['name' => 'description', 'content' => $category->meta->description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $category->meta->description]);
$this->title = $category->meta->title;

$this->params['breadcrumbs'][] = ['label' => 'Отдых и Развлечения', 'url' => Url::to(['funs/index'])];
$this->params['breadcrumbs'][] = $category->name;

$this->params['canonical'] = Url::to(['funs/category', 'id' => $category->id], true);

$this->params['fun'] = true;
MagnificPopupAsset::register($this);
MapAsset::register($this);
$mobile = SysHelper::isMobile();
$this->params['emoji'] = Emoji::FUN;

?>

<h1><?= $category->title ?></h1>
<p class="pt-4">База развлечений и мест отдыха наполняется ... </p>
<p>Подождите немного, через несколько дней мы постараемся ее наполнить</p>

<?= NewProviderWidget::widget()?>