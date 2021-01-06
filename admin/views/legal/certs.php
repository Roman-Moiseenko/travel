<?php

use booking\entities\admin\Cert;
use booking\entities\admin\ContactAssignment;
use booking\entities\admin\Legal;
use booking\forms\admin\CertForm;
use booking\forms\admin\ContactAssignmentForm;
use booking\helpers\ContactHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var  $legal Legal */
/* @var $model CertForm */


$this->title = 'Сертификаты, грамоты и др. документы';
$this->params['breadcrumbs'][] = ['label' => $legal->name, 'url' => ['/legal/view', 'id' => $legal->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="card card-secondary">
    <div class="card-header with-border">Новый сертификат</div>
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
                    <div class="col-12">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">

</div>
<?php ActiveForm::end(); ?>
<div class="card card-secondary">
    <div class="card-header">Текущие сертификаты</div>
    <div class="card-body">
        <div class="col-md-8">
            <table class="table table-adaptive table-striped table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Дата выдачи</th>
                    <th>Документ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php /* @var $cert Cert */ ?>
                <?php foreach ($legal->certs as $cert): ?>
                    <tr>
                        <td width="100px" data-label="Предпросмотр">
                            <a class="thumbnail" href="<?= $cert->getImageFileUrl('file') ?>">
                                <img src="<?= $cert->getThumbFileUrl('file', 'admin') ?>"/>
                            </a>
                        </td>
                        <td width="150px" data-label="Дата выдачи">
                            <?= date('d-m-Y', $cert->issue_at) ?>
                        </td>
                        <td data-label="Документ">
                            <?= $cert->name ?>
                        </td>
                        <td width="80px" data-label="Действия">
                            <a href="<?= Url::to(['/legal/cert-update', 'id' => $cert->id]) ?>" title="Изменить">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                            <a href="<?= Url::to(['/legal/cert-remove', 'id' => $cert->id]) ?>" title="Удалить">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>