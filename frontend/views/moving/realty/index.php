<?php

use booking\entities\Lang;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Недвижимость для переезжающих на ПМЖ в Калининград';
$this->registerMetaTag(['name' => 'description', 'content' => 'СЕО текст для переезда на ПМЖ в Калининград']);

$this->params['canonical'] = Url::to(['/moving/houses'], true);
$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = 'Недвижимость';
?>
<h1>Недвижимость в Калининграде</h1>
<div class="pt-4"></div>
<div class="indent text-justify p-4">
    Раздел находится в разработке
</div>

И Н Ф О Р М А Ц И Я