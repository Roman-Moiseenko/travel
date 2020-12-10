<?php


use booking\entities\booking\funs\Fun;


/* @var  $fun Fun */
/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\DataProviderInterface */

$js = <<<JS
    let fun_id = $fun->id;
    //Событие при выборе даты
    $(document).on('change', '#selling-calendar', function () {
            let _date = $(this).val();
            if (_date === "") {
                $('#select-time').html('');
            } else {
                $.post('/fun/selling/get-time', {date: _date, fun_id: fun_id},
                    function (data) {
                    if (!isNaN(data)) {
                        console.log(data);
                        $('#select-time').html('<div id="list-count"></div>');
                        $.post('/fun/selling/get-selling', {calendar_id: data},
                            function (data) {
                                $('#list-count').html(data);
            });                          
                    } else {
                         $('#select-time').html(data);
                         }
                    });
            }
    });
    $(document).on('change', '#selling-fun-time', function() {
        let calendar_id = $(this).val();
        if (calendar_id == -1) {
            $('#list-count').html('');
        } else {
            $.post('/fun/selling/get-selling', {calendar_id: calendar_id},
                function (data) {
                    $('#list-count').html(data);
            });     
        }
    });
    $(document).on('click', '#selling-add', function() {
        let calendar_id  = $('#calendar_id').data('id');
        console.log(calendar_id);
        let _count  = $('#selling-count').val();
        $.post('/fun/selling/add-selling', {calendar_id: calendar_id, count: _count},
            function (data) {
            $('#list-count').html(data);
        });      
    });
    $(document).on('click', '#selling-remove', function() {
        let selling_id  = $(this).data('id');
        let calendar_id  = $('#calendar_id').data('id');
        $.post('/fun/selling/remove-selling', {selling_id: selling_id, calendar_id: calendar_id},
            function (data) {
                $('#list-count').html(data);
        });      
    });
    
JS;

$this->registerJs($js);
$this->title = 'Прямая продажа ' . $fun->name;
$this->params['id'] = $fun->id;
$this->params['breadcrumbs'][] = ['label' => 'Развлечения', 'url' => ['/funs']];
$this->params['breadcrumbs'][] = ['label' => $fun->name, 'url' => ['/fun/common', 'id' => $fun->id]];
$this->params['breadcrumbs'][] = 'Прямая продажа';
?>

<div class="selling-fun">
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

