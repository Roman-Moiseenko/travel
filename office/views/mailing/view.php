<?php

use booking\entities\mailing\Mailing;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $mailing Mailing */

$this->title = 'Рассылка ' . Mailing::nameTheme($mailing->theme);
$this->params['breadcrumbs'][] = ['label' => 'Рассылка', 'url' => ['index']];
\yii\web\YiiAsset::register($this);
?>
<div class="mailing-view">
    <?php if (!$mailing->isSend()): ?>
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $mailing->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $mailing->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить Рассылку?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Отправить', ['send', 'id' => $mailing->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Вы уверены, что хотите отправить Рассылку?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php endif; ?>
    <div class="card">
        <div class="card-header with-border">Общие</div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $mailing,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'theme',
                        'value' => Mailing::nameTheme($mailing->theme),
                        'label' => 'Тема'
                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => date('d-m-Y', $mailing->created_at),
                        'label' => 'Дата создания'
                    ],
                    [
                        'attribute' => 'status',
                        'value' => $mailing->status == Mailing::STATUS_SEND ? 'Отправлен' : 'Новый',
                        'label' => 'Статус'
                    ],
                    [
                        'attribute' => 'send_at',
                        'value' => $mailing->send_at == null ? '' : date('d-m-Y', $mailing->send_at),
                        'label' => 'Дата рассылки'
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header with-border">Содержимое</div>
        <div class="card-body">
            <?= Yii::$app->formatter->asHtml($mailing->subject, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
</div>
