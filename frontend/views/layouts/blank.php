<?php
/* @var $this \yii\web\View */

/* @var $content string */

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

    <div class="row">
        <div id="content" class="col-12">
            <?= $content ?>
        </div>
    </div>
<?php $this->endContent() ?>