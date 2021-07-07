<?php

use booking\entities\booking\trips\Trip;
use booking\helpers\CurrencyHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $trip Trip */
$this->title = 'Мероприятия ' . $trip->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = 'Мероприятия';

?>
    <p>
        <?= Html::a('Создать мероприятие', Url::to(['trip/activity/create', 'id' => $trip->id]), ['class' => 'btn btn-success']) ?>
    </p>

    <div class="card card-secondary">
        <div class="card-header">Мероприятия тура</div>
        <div class="card-body">
            <table class="table table-adaptive table-striped">
                <thead>
                <tr>
                    <td>День</td>
                    <td>Описание</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($trip->activityDayTimeSort() as $day => $times): ?>
                    <tr>
                        <td><?= $day == 0 ? 'Дополнительные мероприятия' : $day ?></td>
                        <td>
                            <?php foreach ($times as $time => $activities): ?>
                                <div>
                                    <p><label><?= $time ?></label></p>
                                    <?php foreach ($activities as $activity): ?>
                                        <label><?= $activity->caption ?>
                                        <?php if (!empty($activity->cost)) echo ' (' . CurrencyHelper::stat($activity->cost) . ') ';?>
                                        </label>
                                        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $activity->id], [
                                            'class' => 'btn btn-default',
                                            'data-method' => 'post',
                                        ]); ?>
                                        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $activity->id], [
                                            'class' => 'btn btn-default',
                                            'data-method' => 'post',
                                        ]); ?>
                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $activity->id], [
                                            'class' => 'btn btn-default',
                                            'data-method' => 'post',
                                        ]); ?>
                                        <div class="ml-4">
                                            <?= Yii::$app->formatter->asHtml($activity->description, [
                                                'Attr.AllowedRel' => array('nofollow'),
                                                'HTML.SafeObject' => true,
                                                'Output.FlashCompat' => true,
                                                'HTML.SafeIframe' => true,
                                                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                                            ]) ?>
                                        </div>

                                        <div>
                                            <ul class="thumbnails">
                                                <?php foreach ($activity->photos as $i => $photo): ?>
                                                    <li class="image-additional"><a class="thumbnail"
                                                                                    href="<?= $photo->getThumbFileUrl('file', 'catalog_origin') ?>"
                                                                                    target="_blank">
                                                            <img src="<?= $photo->getThumbFileUrl('file', 'cabinet_list'); ?>"
                                                                 alt="<?= $activity->caption; ?>"/>
                                                        </a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <p class="ml-4">
                                            <?= $activity->address->address . ' (' . $activity->address->latitude . ', ' . $activity->address->longitude . ')' ?>
                                        </p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


<?php if ($trip->filling) {
    echo Html::a('Далее >>', Url::to(['filling', 'id' => $trip->id]), ['class' => 'btn btn-primary']);
}
?>