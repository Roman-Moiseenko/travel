<?php

use booking\entities\Lang;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
//$message = new Swift_Message('My subject');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= \Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <table style="width: 100%; height: auto; background-color: #2aabd2; border: 0;">
        <tbody>
        <tr>
            <td style="width: 25%"></td>
            <td style="text-align: left; width: 50%">


                <img src="<?= \Yii::$app->params['staticHostInfo'] .'/files/images/logo-mail.png' ?>" style="width: auto; height: 58px; top: 2px;"/>
                <!-- \Yii::$app->params['staticPath'] . $message->embed(Swift_Image::fromPath(\Yii::$app->params['staticPath'] . '/files/images/logo-mail.png'))
$message->embed(Swift_Image::fromPath('http://static.travel.loc/files/images/logo-mail.png'));
                \Yii::$app->params['staticHostInfo'] .'/files/images/logo-mail.png'

                -->
            </td>
            <td style="width: 25%"></td>
        </tr>
        </tbody>
    </table>
    <?= $content ?>
    <hr/>
    <table style="width: 100%; height: 60px;">
    <tr>
        <td style="width: 20%"></td>
        <td style="width: 60%; text-align: center; font-size: 10px; background-color: #dbdbdb">
            Copyright © 2020 Koenigs.ru. <?= Lang::t('Все права защищены', Lang::DEFAULT) ?>. <br>
        <?= Lang::t('Данное электронное сообщение было отправлено компанией', Lang::DEFAULT) ?> <a style="text-decoration: none; color: #0071c2;" href="<?= \Yii::$app->params['frontendHostInfo']?>"><?= \Yii::$app->params['frontendHostInfo']?></a>
        </td>
        <td style="width: 20%"></td>
    </tr>
    </table>
    <?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
