<?php

use booking\entities\booking\stays\comfort_room\ComfortRoomCategory;
use booking\forms\booking\stays\AssignComfortRoomForm;
use kartik\widgets\FileInput;
use yii\bootstrap4\ActiveForm;

/* @var $assignComfortRoomForm AssignComfortRoomForm */
/* @var $category ComfortRoomCategory */
/* @var $form ActiveForm */
/* @var $i integer */

?>

<?php

$comfort = $assignComfortRoomForm->_comfort;
if ($comfort->category_id == $category->id): ?>
    <div class="d-flex">
        <?php
        echo '<div class="px-2">' . $form
                ->field($assignComfortRoomForm, '[' . $i . ']checked')
                ->checkbox([])
                ->label($comfort->name) . '</div>';
        echo $form
            ->field($assignComfortRoomForm, '[' . $i . ']comfort_id')
            ->textInput(['type' => 'hidden'])
            ->label(false);
        if ($comfort->photo) {
            echo '<div class="px-2">' .
                $form->field($assignComfortRoomForm, '[' . $i . ']file')->widget(FileInput::class, [
                    'language' => 'ru',
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => true,
                        'showRemove' => false,
                        'showPreview' => false,
                        'showCancel' => false,
                        'showCaption' => false,
                        'showUpload' => false,
                        'browseLabel' => '',
                        'browseClass' => 'btn btn-outline-primary btn-file',
                    ],
                ])->label(false) .
                '</div>';
            if ($assignComfortRoomForm->_assignComfort) {
                echo '<a class="up-image" href="#"><i class="fas fa-file-image" style="color: #0c525d; font-size: 28px;"></i>'.
                    '<span><img src="' . $assignComfortRoomForm->_assignComfort->getThumbFileUrl('file','thumb') . '" alt=""></span>'.
                    '</a>';
            }
        }
        ?>
    </div>
<?php endif; ?>
