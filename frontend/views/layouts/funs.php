<?php
/* @var $this \yii\web\View */

/* @var $content string */

use frontend\widgets\SearchToursWidget;
use yii\helpers\Url;

$description = 'Развлечение и отдых в Калининграде, активный отдых на параплане, конных прогулках, пострелять в тире, сходить в баню или культурный посещение музея выставок поплавать в бассейне';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'развлечения,отдых,Калининград,прогулки,полеты,достопримечательности']);
$this->params['canonical'] = Url::to(['/funs'], true);

?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<?php $this->endContent() ?>
