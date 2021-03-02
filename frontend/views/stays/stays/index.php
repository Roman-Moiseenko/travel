<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SearchStayForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;

use booking\forms\booking\stays\SearchStayForm;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

$this->title = Lang::t('Аренда квартир и домов в Калининграде и области');

$js_search = <<<JS
$(document).ready(function() {
    $('body').on('change', '.change-attr', function () {
        let date_from = $('#searchstayform-date_from').val();
        let date_to = $('#searchstayform-date_to').val();
        let city = $('#city').val();
        let guest = $('#guest').val();
        let type = $(this).val();
        $.post("/stays/stays/get-search", {type: type, date_from: date_from, date_to: date_to, city: city, guest: guest}, function (data) {
            //console.log(data);
            $('.block-search-stay').html(data);
            //$(".krajee-datepicker").datepicker();
            //initDPRemove('car-range');
            //initDPAddon('car-range');
        });
    });

});
JS;

$this->registerJs($js_search);
?>

<div class="list-cars">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-3 p-2">
            <div class="leftbar-search-stays">
                <div class="block-search-stay">
            <?= $this->render('_search', ['model' => $model]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <?= $this->render('_list', ['dataProvider' => $dataProvider]) ?>
        </div>
    </div>
</div>
