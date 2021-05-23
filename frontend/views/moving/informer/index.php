<?php

use booking\entities\Lang;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Выбираем регион проживания - Калининград';
$this->registerMetaTag(['name' => 'description', 'content' => 'СЕО текст для переезда на ПМЖ в Калининград']);

$this->params['canonical'] = Url::to(['/moving/area'], true);
$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = 'Калининград';
?>
<h1>Выбираем регион проживания</h1>

<?= $this->render('text_1'); ?>

И Н Ф О Р М А Ц И Я
