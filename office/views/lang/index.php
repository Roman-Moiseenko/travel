<?php

use booking\forms\LangForm;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\LangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model LangForm */

$js = <<<JS
$('#translateModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget); // Button that triggered the modal
  var recipient = button.data('whatever'); // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  modal.find('.modal-title').text(recipient);
  modal.find('#langform-ru').val(recipient);
})
JS;

$this->registerJs($js);
$this->title = 'Перевод';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provider-list">

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-adaptive table-striped table-bordered',
                ],
                'columns' => [
                    [
                        'attribute' => 'ru',
                        'contentOptions' => ['data-label' => 'ru'],
                    ],
                    [
                        'attribute' => 'en',
                        'contentOptions' => ['data-label' => 'en'],
                    ],
                    [
                        'attribute' => 'pl',
                        'contentOptions' => ['data-label' => 'pl'],
                    ],
                    [
                        'attribute' => 'de',
                        'contentOptions' => ['data-label' => 'de'],
                    ],
                    [
                        'attribute' => 'fr',
                        'contentOptions' => ['data-label' => 'fr'],
                    ],
                    [
                        'attribute' => 'lt',
                        'contentOptions' => ['data-label' => 'lt'],
                    ],
                    [
                        'attribute' => 'lv',
                        'contentOptions' => ['data-label' => 'lv'],
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return '<button title="Перевод" type="button" class="btn btn-sm" data-toggle="modal" data-target="#translateModal" data-whatever="' .
                                    $model->ru .
                                    '" style="color: #34a0cf; font-size: 1rem"><i class="fas fa-language"></i></button>';
                            },
                            'delete'  => function ($url, $model, $key) {
                                return Html::a('<i class="far fa-trash-alt"></i>', $url, [
                                    'title' => 'Заблокировать',
                                    'aria-label' => 'Заблокировать',
                                    'data-pjax' => 0,
                                    'data-confirm' => 'Вы уверены, что хотите заблокировать Промо-код ' . $model->ru . '?',
                                    'data-method' => 'post',
                                    'style' => 'color: #34a0cf; font-size: 1rem',
                                ]);
                            }
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <div class="modal fade" id="translateModal" tabindex="-1" role="dialog" aria-labelledby="translateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="translateModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php $form = ActiveForm::begin([
                ]); ?>
                <div class="modal-body">
                    <?= $form->field($model, 'ru')->textInput(['readonly' => true])->label(false) ?>
                    <?= $form->field($model, 'en')->textInput(['placeholder' => 'en'])->label(false) ?>
                    <?= $form->field($model, 'pl')->textInput(['placeholder' => 'pl'])->label(false)  ?>
                    <?= $form->field($model, 'de')->textInput(['placeholder' => 'de'])->label(false)  ?>
                    <?= $form->field($model, 'fr')->textInput(['placeholder' => 'fr'])->label(false)  ?>
                    <?= $form->field($model, 'lt')->textInput(['placeholder' => 'lt'])->label(false)  ?>
                    <?= $form->field($model, 'lv')->textInput(['placeholder' => 'lv'])->label(false)  ?>
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

