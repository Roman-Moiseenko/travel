<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget;
use yii\helpers\Url;

$description = 'Рестораны Калининграда где недорого и вкусно поесть кафе, пиццерии, кофейни, морепродукты, попить кофес круассанами, заказать пиво в пабе и баре, перекусить суши';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'где поесть,ресторан,Калининград,кафе,кухня,пить кофе,деликатесы']);
$this->params['canonical'] = Url::to(['/foods'], true);

?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
