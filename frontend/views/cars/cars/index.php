<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchCarForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;
use booking\forms\booking\cars\SearchCarForm;
use booking\forms\booking\tours\SearchTourForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

$this->title = Lang::t('Прокат бюджетных и комфортных автомобилей, велосипедов, скутеров в Калининграде');

$js_search = <<<JS
$(document).ready(function() {
    $('body').on('change', '.change-attr', function () {
        let date_from = $('#searchcarform-date_from').val();
        let date_to = $('#searchcarform-date_to').val();
        let city = $('#city').val();
        let type = $(this).val();
        $.post("/cars/cars/get-search", {type: type, date_from: date_from, date_to: date_to, city: city}, function (data) {
            $('.block-search-car').html(data);
        });
    });

});
JS;

$this->registerJs($js_search);

$js = <<<JS
    $(document).ready(function() {
       // $('#info').modal('show');
    });
JS;
$this->registerJs($js);
?>

<div class="list-cars">
    <h1><?= Lang::t('Прокат авто, велосипедов, скутеров в Калининграде и области') ?></h1>
    <div class="row">
        <div class="col-sm-3 p-2">
            <div class="leftbar-search-cars">
                <div class="block-search-car">
                    <?= $this->render('_search', ['model' => $model]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
        </div>
    </div>
</div>
