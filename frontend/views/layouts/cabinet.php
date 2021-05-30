<?php
/* @var $this \yii\web\View */
/* @var $content string */

use booking\entities\Lang;
use booking\entities\user\User;
use frontend\widgets\UserMenuWidget;
use yii\helpers\Html;
use yii\helpers\Url;
$this->params['notMap'] = true;

?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

    <div class="row">
        <div id="content" class="col-sm-9">
            <?= $content ?>
        </div>

        <aside id="column-right" class="col-sm-3 hidden-xs">
                <div class="list-group">
                    <?= UserMenuWidget::widget([
                        'type' => UserMenuWidget::CABINET_USERMENU,
                        'class_list' => 'list-group-item',
                    ]) ?>
            </div>
        </aside>
    </div>
<?php $this->endContent() ?>