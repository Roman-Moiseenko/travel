<?php

use yii\helpers\Url;
/* @var $this \yii\web\View */

/* @var $content string */


$description = 'Снять и забронировать посуточно апартаменты, квартиру, загородный дом или дачу целиком недорого в Калининграде на берегу моря, бронирование жилья на лето и отдых';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);

$this->registerMetaTag(['name' =>'keywords', 'content' => 'квартиры,посуточно,аренда,жилья,Калининград,отдых']);
$this->params['canonical'] = $this->params['canonical'] ?? Url::to(['/stays'], true);
$this->params['stay'] = true;

?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<?php $this->endContent() ?>

