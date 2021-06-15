<?php

use booking\entities\booking\BasePhoto;
use booking\forms\MetaForm;
use booking\forms\office\AltForm;
use frontend\assets\MagnificPopupAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $objects array */
/* @var $model MetaForm */
$js = <<<JS
$('#metaModal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget); 
  let _id = button.data('id'); 
  let _class_name = button.data('class-name'); 

  let modal = $(this);
  modal.find('#id').val(_id);
  modal.find('#class_name').val(_class_name);

})
JS;
$this->registerJs($js);
$this->title = 'Мета Теги';
$this->params['breadcrumbs'][] = $this->title;
MagnificPopupAsset::register($this);
?>
<p>
    <?= Html::a('Экскурсии', ['tours'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Авто', ['cars'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Отдых', ['funs'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Жилье', ['stays'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Магазины', ['shops'], ['class' => 'btn btn-info']) ?>
    <?= Html::a('Товары', ['products'], ['class' => 'btn btn-info']) ?>
</p>
    <div class="card">
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
                <tbody>
                <?php foreach ($objects as $object): ?>
                    <tr>
                        <td data-label="Фото">
                            <span class="object_photo">
                                    <img src="<?= $object['photo']; ?>"/>
                            </span>
                        </td>
                        <td data-label="Название"><?= $object['name'] ?></td>
                        <td data-label="Описание"><?= $object['description'] ?></td>
                        <td data-label="Alt">
                            <button title="Alt" type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#metaModal"
                                    data-id="<?= $object['id'] ?>"
                                    data-class-name="<?= $object['class'] ?>"
                                    style="color: #f4ffff; font-size: 1rem">Meta
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="metaModal" tabindex="-1" role="dialog" aria-labelledby="translateModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="translateModalLabel">Мета теги</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php $form = ActiveForm::begin([
                    ]); ?>
                    <div class="modal-body">
                        <?= $form->field($model, 'title')->textInput(['id' => 'title'])->label('Заголовок') ?>
                        <?= $form->field($model, 'description')->textarea(['id' => 'description'])->label('Описание') ?>
                        <?= $form->field($model, 'keywords')->textInput(['id' => 'keywords'])->label('Ключевые слова') ?>
                        <?= $form->field($model, 'id')->textInput(['type' => 'hidden', 'id' => 'id'])->label(false) ?>
                        <?= $form->field($model, 'class_name')->textInput(['type' => 'hidden', 'id' => 'class_name'])->label(false) ?>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $js2 = <<<EOD
    $(document).ready(function() {
        $('.object_photo').magnificPopup({
            type:'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
    });
EOD;
$this->registerJs($js2); ?>