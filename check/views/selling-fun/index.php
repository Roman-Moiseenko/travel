<?php


use booking\entities\booking\funs\Fun;
use yii\helpers\Url;

/* @var  $fun Fun */
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $object_id int */

$js = <<<JS
    let fun_id = $fun->id;
    //Событие при выборе даты
    $(document).on('change', '#selling-calendar', function () {
            let _date = $(this).val();
            if (_date === "") {
                $('#select-time').html('');
            } else {
                $.post('/selling-fun/get-time', {date: _date, fun_id: fun_id },
                    function (data) {
                         $('#select-time').html(data);
                    });
            }
    });
    $(document).on('change', '#selling-fun-time', function() {
        let calendar_id = $(this).val();
        if (calendar_id == -1) {
            $('#list-count').html('');
        } else {
            $.post('/selling-fun/get-selling', {calendar_id: calendar_id},
                function (data) {
                    $('#list-count').html(data);
            });     
        }
    });
    $(document).on('click', '#selling-add', function() {
        let calendar_id  = $('#selling-fun-time').val();
        let _count  = $('#selling-count').val();
        $.post('/selling-fun/add-selling', {calendar_id: calendar_id, count: _count},
            function (data) {
            $('#list-count').html(data);
        });      
    });
    $(document).on('click', '#selling-remove', function() {
        let selling_id  = $(this).data('id');
        let calendar_id  = $('#selling-fun-time').val();
        $.post('/selling-fun/remove-selling', {selling_id: selling_id, calendar_id: calendar_id},
            function (data) {
                $('#list-count').html(data);
        });      
    });
    
JS;

$this->registerJs($js);
$this->title = 'Прямая продажа ' . $fun->name;
?>
<div class="d-flex p-2 justify-content-center" style="background-color: #85c17c; color: #134b18; font-size: 26px; font-weight: 600; text-align:  center;">
    <?= '<a class="link-head" href="' . Url::to(['/give/view', 'id' => $object_id]). '"><i class="fas fa-reply"></i></a>&#160;' . $fun->name ?>
</div>
<div class="selling-tour pt-2">
    <div class="col-sm-3">
    <div class="card">
        <div class="card-body">
            <div>
                <label for="selling-calendar"><b><?= 'Установите дату' ?>:</b></label>
                    <input id="selling-calendar" type="date" class="form-control" value="0000-00-00"/>
            </div>
            <div id="select-time"></div>
        </div>
    </div>
    </div>
</div>

