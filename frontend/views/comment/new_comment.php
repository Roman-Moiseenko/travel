<?php



/* @var $this \yii\web\View */

use yii\bootstrap\ActiveForm;


?>

<?php $form = ActiveForm::begin([]); ?>


<?= yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['auth/network/auth'],
]); ?>

<?php ActiveForm::end(); ?>