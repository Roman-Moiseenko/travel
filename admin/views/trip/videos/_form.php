<?php


use booking\entities\booking\BaseVideo;
use booking\forms\booking\VideosForm;

/* @var $this yii\web\View */
/* @var $model VideosForm */

?>

<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'caption')->textInput(['maxlength' => true])->label('Заголовок Видео') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'type_hosting')
                    ->dropDownList(BaseVideo::list())
                    ->label('Видеохостинг') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'url')
                    ->textInput(['maxlength' => true])
                    ->label('Ссылка на файл в видеохостинге') ?>
            </div>
        </div>



    </div>
</div>




