<?php

use booking\entities\moving\agent\Region;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $regions Region[] */

$this->title = 'Представители портала на ПМЖ в Калининград';
$description = 'Наши представители в регионах и земляки в Калининграде окажут помощь в вопросах переезда на ПМЖ в Калининград';
$this->registerMetaTag(['name' => 'description', 'content' => $description]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $description]);

$this->params['slug'] = 'no';
$this->params['canonical'] = Url::to(['/moving/agents'], true);
$this->params['breadcrumbs'][] = ['label' => 'На ПМЖ', 'url' => Url::to(['/moving'])];
$this->params['breadcrumbs'][] = 'Представители портала';
?>

<h1>Наши представители в регионах</h1>

<?php foreach ($regions as $region): ?>
    <h2 class="py-4"><?= $region->name ?></h2>

    <?php foreach ($region->agents as $agent): ?>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <img
                    class="img-responsive"
                    alt="Представитель Агентства на ПМЖ в Калининград <?= $agent->person->getFullname() ?>"
                    src="<?= $agent->getThumbFileUrl('photo', 'thumb')?>"
                    style="border-radius: 40px;">
        </div>
        <div class="col-sm-6 col-md-8 col-lg-9">
            <h3><?= $agent->person->getFullname() . ' - ' . $agent->getStringType() ?></h3>
            <p>
                <?= $agent->description ?>
            </p>
            <p>

            </p>
        </div>

    </div>
    <?php endforeach; ?>

    <div class="row py-3">
        <div class="col" style="font-size: 18px;">
        <?= Html::a('Форум для жителей региона ' . $region->name, $region->link) ?>
        </div>
    </div>

<?php endforeach; ?>
