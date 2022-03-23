<?php

use booking\entities\Lang;
use booking\entities\photos\Page;
use booking\forms\photos\ItemForm;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $page Page */
/* @var $model ItemForm */


$this->title = 'Публикация ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Публикации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
$('#itemPhoto').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget); // Button that triggered the modal
  let id = button.data('id'); // Extract info from data-* attributes
  let page = button.data('page'); // Extract info from data-* attributes
  let _caption = '';
  if (id == 0) {_caption = 'Новая фотография'} else {_caption = 'Редактировать'}
  let modal = $(this);
  modal.find('#addPhotoLabel').html(_caption);
 $.get('get-item', {id: page, item_id: id}, function(data) {
   modal.find('#data-load').html(data);
 });
})
JS;

$this->registerJs($js);
?>

<p>
    <?php if ($page->isActive()): ?>
        <?= Html::a('Снять с публикации', ['draft', 'id' => $page->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
    <?php else: ?>
        <?= Html::a('Опубликовать', ['activate', 'id' => $page->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
    <?php endif; ?>
    <?= Html::a('Изменить', ['update', 'id' => $page->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $page->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Удалить статью?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<div class="card">
    <div class="card-body">
        <?= $page->description ?>
        <p> Теги:
            <?php foreach ($page->tags as $tag): ?>
                <?= $tag->name . ', ' ?>
            <?php endforeach; ?>
        </p>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <button title="Добавить Фотографию" type="button" class="btn btn-primary" data-toggle="modal"
                data-target="#itemPhoto"
                data-page="<?= $page->id ?>" data-id="0">Добавить Фотографию
        </button>
    </div>
    <div class="card-body">
        <div id="list-items-page-photo"></div>
        <table class="table">

            <?php foreach ($page->items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><img src="<?= $item ? $item->getThumbFileUrl('photo', 'admin') : '' ?>"></td>
                    <td><?= $item->name ?></td>
                    <td><?= $item->description ?></td>
                    <td>                        <?=
                        Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $page->id, 'item_id' => $item->id],
                            ['data-method' => 'post',]) .
                        Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $page->id, 'item_id' => $item->id],
                            ['data-method' => 'post',]);
                        ?></td>
                    <td>
                        <button id="edit_button" title="Редактировать" type="button" class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#itemPhoto"
                                data-page="<?= $item->page_id ?>" data-id="<?= $item->id ?>">Редактировать
                        </button>
                    </td>
                    <td><?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-item', 'id' => $page->id, 'item_id' => $item->id], [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить Фотографию?',
                                'method' => 'post',
                            ],
                        ]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- МОДАЛЬНОЕ ОКНО -->
<div class="modal fade" id="itemPhoto" tabindex="-1" role="dialog" aria-labelledby="addPhotoLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPhotoLabel">Новая фотография</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="data-load"></div>
        </div>
    </div>
</div>
