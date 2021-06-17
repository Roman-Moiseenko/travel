<?php


use booking\forms\booking\trips\TripCommonForm;
use booking\helpers\trips\TripTypeHelper;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model TripCommonForm */


?>

<div class="card card-secondary">
    <div class="card-header with-border">Основные</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название тура') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'slug')
                    ->textInput(['maxlength' => true])
                    ->label('Уникальная ссылка')
                    ->hint('Оставьте пустым для автоматической генерации<br>Не меняйте если экскурсия уже активирована!<br>Если после смены ссылки, экскурсия стала недоступна на сайте, напишите в поддержку!') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <span class="badge badge-success" style="font-size: 16px;">Рекомендация к заполнению!</span><br>
                <span class="badge badge-danger">1.</span> Избегайте слов паразитов и используйте поменьше слов без информационной нагрузки, так называемая "вода"<br>
                <span class="badge badge-danger">2.</span> В тексте должны встречаться ключевые слова, по которым гости будут искать Ваш тур.
                Главное слово "экскурсия", которое должно присутствовать во всех экскурсиях.
                Остальные, в зависимости от Вашей экскурсии, например в экскурсиях по городу, должны присутствовать слова: Калининград, Кёнигсберг, город, музей, обзорная, и желательно более 1 раза.<br>
                <span class="badge badge-danger">3.</span> Разбейте текст на несколько частей/глав.<br>
                <span class="badge badge-danger">4.</span> У каждой части должен быть заголовок.<br>
                <span class="badge badge-danger">5.</span> Выделите заголовок и нажмите кнопку <b>"Формат ... "</b> и выберите <b>"Заголовок 2"</b><br>
                <span class="badge badge-danger">6.</span> Не называйте экскурсию одним словом, старайтесь раскрыть суть экскурсии в заголовке.<br>
                <span class="badge badge-danger">7.</span> В качестве примера посмотрите экскурсию <a href="https://koenigs.ru/ru/tour/shaaken" target="_blank">Шаакен - орденский замок</a><br>
            </div>
        </div>
        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание')->widget(CKEditor::class) ?>
    </div>
</div>
<div class="card card-secondary">
    <div class="card-header with-border">Основные EN</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true])->label('Название тура (En)') ?>
            </div>
        </div>
        <?= $form->field($model, 'description_en')->textarea(['rows' => 6])->label('Описание (En)')->widget(CKEditor::class) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-secondary">
            <div class="card-header with-border">Категории</div>
            <div class="card-body">
                <?= $form->field($model->types, 'main')->dropDownList(TripTypeHelper::list(), ['prompt' => ''])->label('Основная') ?>
                <?= $form->field($model->types, 'others')->checkboxList(TripTypeHelper::list())->label('Дополнительно') ?>
            </div>
        </div>
    </div>
</div>

