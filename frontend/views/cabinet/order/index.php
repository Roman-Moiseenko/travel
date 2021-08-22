<?php

use booking\entities\Lang;
use booking\helpers\SysHelper;
use yii\data\DataProviderInterface;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $dataProvider DataProviderInterface */
/* @var $active string */
/* @var $counts array */
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->title = Lang::t('Мои заказы');
$mobil = SysHelper::isMobile();

?>

<h1><?= Lang::t('Заказы') ?></h1>

<p class="py-4">
    <?= Html::a(Lang::t('Новые') . ' (' . $counts['new'] . ')', ['index'], ['class' => 'btn-tab-order ' . ($active == 'new' ? 'active' : '')]) ?>
    <?= Html::a(Lang::t('В работе') . ' (' . $counts['work'] . ')', ['work'], ['class' => 'btn-tab-order ' . ($active == 'work' ? 'active' : '')]) ?>
    <?= Html::a(Lang::t('Завершенные') . ' (' . $counts['completed'] . ')', ['completed'], ['class' => 'btn-tab-order ' . ($active == 'completed' ? 'active' : '')]) ?>
    <?= Html::a(Lang::t('Отмененные') . ' (' . $counts['canceled'] . ')', ['canceled'], ['class' => 'btn-tab-order ' . ($active == 'canceled' ? 'active' : '')]) ?>
</p>


<?php foreach ($dataProvider->getModels() as $i => $model): ?>
    <?= $this->render($mobil ? '_order_mobile' : '_order', [
        'order' => $model,
        'iterator' => $i
    ]) ?>
<?php endforeach; ?>

<div class="row">
    <div class="col-sm-6 text-left">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </div>
    <div class="col-sm-6 text-right"><?= Lang::t('Показано') . ' ' . $dataProvider->getCount() . ' ' . Lang::t('из') . ' ' . $dataProvider->getTotalCount() ?></div>
</div>

