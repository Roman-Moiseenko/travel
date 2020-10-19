<?php

use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\LangForm;
use booking\helpers\DialogHelper;
use office\forms\DialogsSearch;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel office\forms\LangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model LangForm */

$js = <<<JS
$('#translateModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(recipient)
  modal.find('.modal-body #recipient-name').val(recipient)
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
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {

                                    //$url = Url::to(['/', 'id' => $model->ru]);
                                    //$icon = Html::tag('i', '', ['class' => "fas fa-user-lock"]);
                                    return '<button type="button" class="btn btn-sm" data-toggle="modal" data-target="#translateModal" data-whatever="'.
                                        $model->ru.
                                        '"><i class="fas fa-language"></i></button>';
                                    return Html::a($icon, $url, [
                                        'title' => 'Перевод',
                                        'aria-label' => 'Перевод',
                                        'data-pjax' => 0,
                                        'data-method' => 'post',
                                    ]);

                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <div class="modal fade" id="translateModal" tabindex="-1" role="dialog" aria-labelledby="translateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="translateModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin([
                    ]); ?>
                    <?= $form->field($model, 'ru')->textInput()?>
                    <?= $form->field($model, 'en')->textInput()?>
                    <?= $form->field($model, 'pl')->textInput()?>
                    <?= $form->field($model, 'de')->textInput()?>
                    <?= $form->field($model, 'fr')->textInput()?>
                    <?= $form->field($model, 'lt')->textInput()?>
                    <?= $form->field($model, 'lv')->textInput()?>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">ru:</label>
                            <input type="text" class="form-control" id="recipient-name" disabled>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
</div>
