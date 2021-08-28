<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use booking\entities\Lang;
use yii\helpers\Html;


if (isset(\Yii::$app->params['errors'][$exception->statusCode])) {
    $custom_name = \Yii::$app->params['errors'][$exception->statusCode];
} else {
    $custom_name = $name;
}

$this->title = $custom_name;

?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--div class="alert alert-danger">
        <?= ''//nl2br(Html::encode($message)) ?>
    </div-->
    <span class="params-tour">
    <p>
        <?= Lang::t('Вышеуказанная ошибка произошла, когда веб-сервер обрабатывал ваш запрос.') ?>
    </p>
    <p>
        <?= Lang::t('Пожалуйста, свяжитесь с нами, если вы считаете, что это ошибка сервера. Спасибо.') ?>
    </p>
    </span>
    <p>
        <img src="https://static.koenigs.ru/images/page/about/koenigs-about-2.jpg" alt="about" class="card-img-top"/>
    </p>

</div>
