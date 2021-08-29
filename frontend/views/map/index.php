<?php



/* @var $this \yii\web\View */

use booking\helpers\Emoji;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $array array */

$this->title = 'Карта сайта - Калининград';
$description = 'Карта сайте, где можно заказать любую туристическую услугу в Калининграде или получить комплекс услуг по переезду на ПМЖ в Калинингради комплекс услуг по медицинскому туризму';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
$this->params['canonical'] = Url::to(['/map'], true);
$this->params['emoji'] = Emoji::MAIN;
?>
<h1 class="py-3">Карта сайта</h1>
<div>
    <?php foreach ($array as $item): ?>
        <p>
            <?=  ($item['lvl'] > 0 ? str_repeat('--', $item['lvl']) . ' ' : '') . Html::a($item['caption'], $item['link']) ?>
        </p>
    <?php endforeach; ?>
</div>