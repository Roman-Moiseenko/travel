<?php

use booking\entities\moving\CategoryFAQ;
use booking\entities\user\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $categories CategoryFAQ[] */
/* @var $user User */

$this->title = 'Переезд на ПМЖ в Калининград - вопросы и ответы';
$this->registerMetaTag(['name' => 'description', 'content' => 'СЕО текст для форума по переезду на ПМЖ в Калининград']);
$this->params['canonical'] = Url::to(['/moving/faq'], true);

$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = 'Форум';
if ($user && $user->username == \Yii::$app->params['moving_moderator']) {$iModerator = true;}
else {$iModerator = false;}
?>
<h1>Переезд на ПМЖ в Калининград</h1>
<div class="pt-4"></div>
<div class="indent params-tour text-justify p-4">
    Форум вопросов и ответов. Задайте интересующий Вас вопрос о Калининграде в соответствующем разделе и наши профильные
    специалисты ответят на него в кратчайшие сроки. Если Вы оставите свою электронную почту, то копию ответа вы получите
    на нее.
</div>
<div class="row params-moving">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <?php foreach ($categories as $category): ?>
            <div class="card m-4" style="border-radius: 20px">
                <div class="card-header d-flex" style="border-radius: 20px">
                    <div>
                        <h2 class="faq-card"><?= $category->caption ?></h2>
                    </div>
                    <div class="ml-auto">
                        <?= $category->countFaq(); ?>
                        <?php if ($iModerator) {
                            $count = $category->countNotAnswer();
                            echo $count != 0 ? '<span class="badge badge-danger">' . $category->countNotAnswer() . '</span>' : '';
                        }
                        ?>
                    </div>
                </div>
                <div class="card-body" style="border-radius: 20px">
                    <?= $category->description ?>
                </div>
                <a class="stretched-link" href="<?= Url::to(['moving/faq/category', 'id' => $category->id]) ?>"></a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
