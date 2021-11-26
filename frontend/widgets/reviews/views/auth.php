<?php

?>

<div class="params-moving">
    <p>Если Вы хотите оставить коментарий, авторизуйтесь через социальные сети</p>
<?= yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['auth/network/auth'],
]); ?>
</div>
