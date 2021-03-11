<?php
/* @var $this \yii\web\View */

/* @var $content string */


$this->registerMetaTag(['name' =>'description', 'content' => 'Снять и забронировать посуточно апартаменты, квартиру, загородный дом или дачу целиком недорого в Калининграде на берегу моря, бронирование жилья на лето и отдых']);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'квартиры,посуточно,аренда,жилья,Калининград,отдых']);
$this->params['canonical'] = Url::to(['/stays'], true);

use yii\helpers\Url; ?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<?php $this->endContent() ?>

