<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $tag Tag */

use booking\entities\blog\Tag;
use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Lang::t('Посты с тегом') . ' ' . $tag->name;
$this->params['canonical'] = Url::to(['/post/tag', 'slug' => $tag->slug], true);
$this->params['breadcrumbs'][] = ['label' => Lang::t('Блог'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $tag->name;
?>

<h1>Посты с тегом &laquo;<?= Html::encode($tag->name) ?>&raquo;</h1>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>


