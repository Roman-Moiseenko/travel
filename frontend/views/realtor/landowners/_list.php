<?php



/* @var $this \yii\web\View */
/* @var $landowners \booking\entities\realtor\Landowner */
?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
    <?php foreach ($landowners as $landowner): ?>
        <?= $this->render('_landowner', [
            'landowner' => $landowner
        ]) ?>
    <?php endforeach; ?>
</div>
