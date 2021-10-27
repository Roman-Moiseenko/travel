<?php

/* @var  $objects BookingObject[] */

use booking\entities\check\BookingObject;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="d-flex flex-column align-items-stretch"">
<?php foreach ($objects as $object): ?>
    <div class="row">
        <div class="col">
            <div class="d-flex p-2 justify-content-center"
                 style="background-color: #85c17c; color: #134b18; font-size: 26px; font-weight: 600; text-align:  center; border-radius: 4px; margin: 1px 1px 1px 1px;">
                <a class="link-head"
                   href="<?= Url::to(['/give/view', 'id' => $object->id]) ?>"> <?= $object->classObject()::findOne($object->object_id)->getName() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="row">
    <div class="col">
        <?= Html::a('<i class="fas fa-sign-out-alt"></i> Выход', ['/logout'], ['data-method' => 'post', 'class' => 'btn btn-info']) ?>
    </div>
</div>

</div>