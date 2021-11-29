<?php



/* @var $this \yii\web\View */
/* @var $lands \booking\entities\realtor\land\Land[] */
$this->title = 'Инвестиционные участки';
$this->params['breadcrumbs'][] = $this->title;

?>

<p>
    <?= \yii\helpers\Html::a('Создать Участок', \yii\helpers\Url::to(['create']), ['class' => 'btn btn-info']) ?>
</p>
<div class="row">
<div class="col-sm-8">
<?php foreach ($lands as $land): ?>
<div class="card card-info">
    <div class="card-header"><?= $land->name ?></div>
    <div class="card">
        <p>
            Текст и Фото
        </p>
        <a href="<?= \yii\helpers\Url::to(['view', 'id' => $land->id]) ?>">Редактировать</a>
    </div>
</div>
<?php endforeach;?>
</div>
</div>