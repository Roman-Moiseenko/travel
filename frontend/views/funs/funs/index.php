<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchFunForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\cars\SearchCarForm;
use booking\forms\booking\funs\SearchFunForm;
use booking\forms\booking\tours\SearchTourForm;
use booking\helpers\Emoji;
use frontend\assets\FunAsset;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

$this->title = Lang::t('Развлечения и мероприятия в Калининграде - активный культурный отдых');

$js_search = <<<JS
$(document).ready(function() {
    $('body').on('change', '.change-attr', function () {
        let date_from = $('#searchfunform-date_from').val();
        let date_to = $('#searchfunform-date_to').val();
        let type = $(this).val();
        $.post("/funs/funs/get-search", {type: type, date_from: date_from, date_to: date_to}, function (data) {
            //console.log(data);
            $('.block-search-fun').html(data);
        });
    });

});
JS;

$this->registerJs($js_search);
$this->params['emoji'] = Emoji::FUN;
?>

<div class="list-cars">
    <h1><?= Lang::t('Развлечения и мероприятия в Калининграде и области') ?></h1>
    <div class="row">
        <div class="col-sm-3 p-2">
            <div class="leftbar-search-funs">
                <div class="block-search-fun">
            <?= $this->render('_search', ['model' => $model]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
        </div>
    </div>
</div>
