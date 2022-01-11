<?php
/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Url;


$description = 'Прокат и аренда автомобиля, скутера, велосипеда, катера или мотоцикла в Калининграде недорогой прокат на сутки комфортабельные автомобили и бюджетные';
$this->registerMetaTag(['name' =>'description', 'content' => $description]);
$this->registerMetaTag(['name' =>'og:description', 'content' => $description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => 'прокат,аренда,автомобили,велосипеды,скутеры,Калининград,Светлогорск,Зеленоградск,Куршская,Янтарный']);
$this->params['canonical'] = $this->params['canonical'] ?? Url::to(['/cars'], true);

?>
<?php $this->beginContent('@frontend/views/layouts/objects.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <?= $content ?>
    </div>

</div>
<?php $this->endContent() ?>
