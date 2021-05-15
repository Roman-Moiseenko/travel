<?php

use booking\entities\moving\FAQ;
use booking\entities\user\User;
use frontend\widgets\design\BtnAnswer;
use frontend\widgets\design\BtnEdit;
use frontend\widgets\design\BtnReview;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $faq FAQ */


$iModerator = \Yii::$app->user->isGuest ? false : (\Yii::$app->user->identity->username == \Yii::$app->params['moving_moderator']);
$Moderator = User::findByUsername(\Yii::$app->params['moving_moderator']);
?>

<div class="сard py-3" style="border-radius: 20px">
    <div class="card-body" style="background-color: white; border-radius: 20px">
        <div class="row">
            <div class="col-sm-9">
                <div style="background-color: #fff9df; padding: 20px; border-radius: 10px;">
                    <div class="d-flex">
                        <div>
                            <?= $faq->username ?>
                        </div>
                        <div class="ml-auto">
                            <?= date('d-m-Y H:i', $faq->created_at) ?>
                        </div>
                    </div>
                    <hr/>
                    <?= Html::encode($faq->question) ?>
                </div>
            </div>
            <div class="col-sm-3 align-self-center">
                <?php if ($faq->isNew() && $iModerator):?>
                    <?= BtnAnswer::widget(['caption' => 'Ответить',
                        'id' => $faq->id,
                        'target' => 'answerModal',
                        ]) ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($faq->isCompleted()): ?>
        <div class="row pt-4">
            <div class="col-sm-3 align-self-center text-center">
                <?php if (!empty($Moderator->personal->photo)): ?>
                    <img src="<?= Html::encode($Moderator->personal->getThumbFileUrl('photo', 'cart_list')) ?>" alt="Модератор"
                         class="img-responsive" style="max-width:100%;height:auto; border-radius: 20px"/>
                <?php else: ?>
                    <img src="<?= Url::to('@static/files/images/no_user.png') ?>" alt=""
                         class="img-responsive" style="width:150px; height: 150px"/>
                <?php endif; ?>
            </div>
            <div class="col-sm-9">
                <div style="background-color: #d4f1ff; padding: 20px; border-radius: 10px;">
                    <div class="d-flex">
                        <div>
                            <?= $Moderator->personal->fullname->getShortname() ?>
                        </div>
                        <div class="ml-auto">
                            <?= date('d-m-Y H:i', $faq->updated_at) ?>
                        </div>
                    </div>
                    <hr/>
                    <?= $faq->answer ?>
                </div>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>
