<?php

use booking\entities\shops\Shop;
use booking\forms\MetaForm;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;


/* @var $searchModel office\forms\seo\SeoShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model MetaForm */
$js = <<<JS
$('#metaModal').on('show.bs.modal', function (event) {
  let button = $(event.relatedTarget); 
  let _id = button.data('id'); 
  let _class_name = button.data('class-name'); 
  let _title = button.data('title'); 
  let _description = button.data('description'); 
  let _keywords = button.data('keywords'); 

  let modal = $(this);
  modal.find('#id').val(_id);
  modal.find('#class_name').val(_class_name);
  modal.find('#title').val(_title);
  modal.find('#description').val(_description);
  modal.find('#keywords').val(_keywords);

})
JS;
$this->registerJs($js);
$this->title = 'Магазины';
$this->params['breadcrumbs'][] = ['label' => 'Мета Теги', 'url' => ['/seo/meta']];
$this->params['breadcrumbs'][] = $this->title;

?>

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
                        'attribute' => 'id',
                        'options' => ['width' => '20px',],
                        'contentOptions' => ['data-label' => 'ID'],
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function (Shop $model) {
                            return Html::a($model->name, ['shop/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'label' => 'Название',
                        'contentOptions' => ['data-label' => 'Название'],
                    ],
                    [
                        'attribute' => 'description',
                        'value' => function (Shop $model) {
                            return Yii::$app->formatter->asHtml($model->description, [
                            'Attr.AllowedRel' => array('nofollow'),
                            'HTML.SafeObject' => true,
                            'Output.FlashCompat' => true,
                            'HTML.SafeIframe' => true,
                            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                        ]);
                            },
                        'format' => 'raw',
                        'label' => 'Описание',
                        'contentOptions' => ['data-label' => 'Описание', 'width' => '50%'],
                    ],
                    [
                        'attribute' => 'meta',
                        'value' => function (Shop $model) {
                            return '<label>' . (empty($model->meta->title) ? '<span class="badge badge-danger">Нет заголовка</span>' : $model->meta->title). '</label>' .
                                '<div>' . (empty($model->meta->description) ? '<span class="badge badge-warning">Нет описания</span>' : $model->meta->description) .'</div>' .
                                '<div><i>' . (empty($model->meta->keywords) ? '<span class="badge badge-info">Нет ключевых слов</span>' : $model->meta->keywords) .'</i></div>';
                        },
                        'format' => 'raw',
                        'label' => 'Мета',
                        'contentOptions' => ['data-label' => 'Мета'],
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, Shop $model, $key) {
                                    $url = '';
                                    $icon = Html::tag('i', '', ['class' => "fas fa-play", 'style' => 'color: #ffc107']);
                                    return '<button title="Alt" type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#metaModal"
                                    data-id="' . $model->id . '"                                    
                                    data-title="'. $model->meta->title . '"
                                    data-description="'. $model->meta->description . '"
                                    data-keywords="'. $model->meta->keywords . '"
                                    style="color: #f4ffff; font-size: 1rem">Meta</button>';
                            },
                        ],
                    ],
                ],
            ]); ?>

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
