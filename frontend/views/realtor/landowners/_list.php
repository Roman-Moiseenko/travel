<?php



/* @var $this \yii\web\View */
/* @var $landowners \booking\entities\realtor\Landowner */
?>


    <?php foreach ($landowners as $landowner): ?>
        <?= $this->render('_landowner', [
            'landowner' => $landowner
        ]) ?>
    <?php endforeach; ?>
