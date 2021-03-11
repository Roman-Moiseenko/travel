<?php

use booking\entities\booking\BasePhoto;
use booking\forms\office\AltForm;
use frontend\assets\MagnificPopupAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $objects BasePhoto[] */
/* @var $model AltForm */
$js = <<<JS
$('#altModal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget); 
  let _id = button.data('id'); 
  let _class_name = button.data('class-name'); 
  let _alt = button.data('alt');

  let modal = $(this);
  modal.find('#id').val(_id);
  modal.find('#alt').val(_alt);
  modal.find('#class_name').val(_class_name);

})
JS;
$this->registerJs($js);
$this->title = 'SEO->IMG Alt';
$this->params['breadcrumbs'][] = $this->title;
MagnificPopupAsset::register($this);
?>
<p>
    <?= Html::a('Новые', ['index'], ['class' => 'btn btn-success']) ?>
</p>
    <div class="card">
        <div class="card-body">
            <table class="table table-adaptive table-striped table-bordered">
                <tbody>
                <?php foreach ($objects as $object): ?>
                    <tr>
                        <td data-label="Фото">
                            <span class="object_photo">
                                <a class=""
                                   href="<?= $object->getThumbFileUrl('file', 'catalog_origin') ?>">
                                    <img src="<?= $object->getThumbFileUrl('file', 'admin'); ?>"/>
                                </a>
                            </span>
                        </td>
                        <td data-label="alt"><b><?= $object->getAlt() ?></b></td>
                        <td data-label="Название"><?= $object->getName() ?></td>
                        <td data-label="Описание"><?= $object->getDescription() ?></td>
                        <td data-label="Alt">
                            <button title="Alt" type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#altModal"
                                    data-id="<?= $object->id ?>"
                                    data-class-name="<?= get_class($object) ?>"
                                    data-alt="<?= $object->getAlt() ?>"
                                    style="color: #f4ffff; font-size: 1rem">Alt
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="altModal" tabindex="-1" role="dialog" aria-labelledby="translateModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="translateModalLabel">Поле <b>alt</b> тэга <b>IMG</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php $form = ActiveForm::begin([
                    ]); ?>
                    <div class="modal-body">
                        <?= $form->field($model, 'alt')->textInput(['id' => 'alt'])->label(false) ?>
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