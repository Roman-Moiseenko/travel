<?php


/* @var $this \yii\web\View */
/* @var $name string */
/* @var $phone string */
/* @var $img string */
/* @var $mobile bool */

?>

<?php if ($mobile): ?>
    <div class="row">
        <div class="col-12">
            <img alt="Олег" class="img-responsive-2"
                 src="<?= $img ?>"
                 style="border-radius: 30px;"/>
        </div>
        <div class="col-12">
            <p style="text-align: center;"><span
                        style="font-size:18px;"><b><?= $name ?></b></span></p>
            <?= \frontend\widgets\design\BtnPhone::widget([
                'caption' => $phone,
                'block' => true,
                'phone' => $phone
            ]) ?>
        </div>
        <div class="ml-auto">
        </div>
    </div>
<?php else: ?>
    <div class="d-flex pt-4">
        <div><img alt="Олег" width="200" height="200"
                  src="<?= $img ?>"
                  style="border-radius: 30px;"/>

        </div>
        <div class="pl-5  d-flex align-items-center">
            <div>
                <p style="text-align: center;"><span
                            style="font-size:18px;"><b><?= $name ?></b></span></p>
                <div class="d-flex justify-content-center">
                    <?= \frontend\widgets\design\BtnPhone::widget([
                        'caption' => $phone,
                        'block' => false,
                        'phone' => $phone
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="ml-auto">
        </div>
    </div>
<?php endif; ?>
