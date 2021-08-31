<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use booking\entities\Lang;
use yii\helpers\Html;
use yii\helpers\Url;


if (isset(\Yii::$app->params['errors'][$exception->statusCode])) {
    $custom_name = \Yii::$app->params['errors'][$exception->statusCode];
} else {
    $custom_name = $name;
}

$this->title = $custom_name;

?>
<div class="site-error">

    <h1 class="py-4"><?= Html::encode($this->title) ?></h1>

    <!--div class="alert alert-danger">
        <?= ''//nl2br(Html::encode($message)) ?>
    </div-->
    <span class="params-tour">
    <p>
        <?= Lang::t('При обработке Вашего запроса произошла ошибка, возможно, данной страницы уже не существует.') ?>
    </p>
    <p>
        <?= Lang::t('Возможно, что-то пошло не так, и если Вам необходимо выполнить Ваш запрос, свяжитесь с нами удобным для Вас способом - ')  ?>
        <?= Html::a('Кёнигс.РУ', Url::to(['/about'], true))?>
    </p>
    </span>
    <p>
        <img src="https://static.koenigs.ru/images/page/about/koenigs-about-2.jpg" alt="about" class="card-img-top"/>
    </p>
</div>
