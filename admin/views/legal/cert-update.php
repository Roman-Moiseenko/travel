<?php


use booking\entities\admin\Cert;
use booking\entities\admin\Legal;
use booking\forms\admin\CertForm;
use booking\forms\admin\ContactAssignmentForm;
use booking\helpers\ContactHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model CertForm */
/* @var  $legal Legal */
/* @var $cert Cert */


$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = ['label' => $legal->name, 'url' => ['/legal/view', 'id' => $legal->id]];
$this->params['breadcrumbs'][] = ['label' => 'Сертификаты', 'url' => ['/legal/certs', 'id' => $legal->id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(); ?>
<div class="card card-secondary">
    <div class="card-header with-border">Редактировать сертификат</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model->file, 'files')->label(false)->widget(FileInput::class, [
                    'language' => 'ru',
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'initialPreview' => [
                            $cert->getThumbFileUrl('file', 'profile'),
                        ],
                        'initialPreviewAsData' => true,
                        'overwriteInitial' => true,
                        'showRemove' => false,
                        'allowedFileExtensions' => ['jpg', 'png'],
                    ],
                ]) ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-4">

                        <?= $form->field($model, 'issue_at')->widget(DatePicker::class, [
                            'type' => DatePicker::TYPE_INPUT,
                            'language' => 'ru',
                            'pluginOptions' => [
                                'format' => 'dd-mm-yyyy',
                                'autoclose' => true,
                            ]
                        ])->label('Дата выдачи')->hint('сортировка идет по дате выдачи') ?>
                    </div>
                    <div class="col-9">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
