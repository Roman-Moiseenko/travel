<?php

use booking\entities\moving\CategoryFAQ;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $categories CategoryFAQ[] */

$this->title = 'Форум по переезду на ПМЖ в Калининград';
$this->registerMetaTag(['name' => 'description', 'content' => 'СЕО текст для форума по переезду на ПМЖ в Калининград']);

$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = 'Форум';

$iModerator = \Yii::$app->user->identity->username == \Yii::$app->params['moving_moderator'];

?>

<h1>Форум по переезду в Калининград</h1>
<div class="pt-4"></div>
<div class="indent text-justify p-4">
    СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст
    .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .
    .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .
    .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .
    .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .
    .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .
    .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .
    .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .
    .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .СЕО Текст .
</div>
<div class="row">
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
    <a class="stretched-link" href="<?=Url::to(['moving/faq/category', 'id' => $category->id])?>"></a>
</div>
<?php endforeach; ?>
    </div>
</div>
