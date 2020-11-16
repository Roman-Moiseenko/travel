<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$this->params['breadcrumbs'] = [['label' => $this->title]];
$custom = isset(\Yii::$app->params['errors'][$exception->statusCode]);
$custom_name = $custom ? $exception->statusCode : Html::encode($name);
$custom_message = $custom ? \Yii::$app->params['errors'][$exception->statusCode] : nl2br(Html::encode($message));
?>
<div class="error-page">
    <div class="error-content" style="margin-left: auto;">
        <h1 style="font-size: 72px"> <span class="badge badge-danger"><?= $custom_name ?></span></h1>
        <h2>
            <i class="fas fa-exclamation-triangle text-danger"></i><?= $custom_message ?>
        </h2>

        <p>
            Вышеуказанная ошибка произошла, когда веб-сервер обрабатывал ваш запрос.
            Пожалуйста, свяжитесь с нами, если вы считаете, что это ошибка сервера. Спасибо!
            Вы можете <?= Html::a('вернуться на предыдущую страницу', Yii::$app->request->referrer); ?>.
        </p>
    </div>
</div>

