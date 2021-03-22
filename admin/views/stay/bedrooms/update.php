<?php

/* @var $this yii\web\View */
/* @var $model StayBedroomsForm */
/* @var $stay Stay */

use booking\entities\booking\stays\bedroom\TypeOfBed;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayBedroomsForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$count_beds = count(TypeOfBed::find()->all());
$max_count_bed = Stay::MAX_BEDROOMS;
$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '#add-bedrooms', function() {
       let stay_id = $('#stay-id').val();
       let count_room = Number($('#count-bedrooms').val());

       let rooms = getRooms(count_room);
        $.post('/stay/bedrooms/add', {stay_id: stay_id, count_room: count_room, rooms: rooms, status: "add"}, function(data) {
            $('#bedroom-list').html(data);
           if (count_room === $max_count_bed - 1) {
               $('#add-bedrooms').hide();
           } else  {
               $('#add-bedrooms').show();
           }            
        });
    });
   
    $('body').on('click', '.del-bedrooms', function() {
       let stay_id = $('#stay-id').val();
       let count_room = $('#count-bedrooms').val();
       let del_room = Number($(this).data('room-id'));
       let rooms = getRooms(count_room);
       rooms.splice(del_room, 1);
       count_room--;
        $.post('/stay/bedrooms/add', {stay_id: stay_id, count_room: count_room, rooms: rooms, status: "sub"}, function(data) {
            $('#bedroom-list').html(data);
            $('#add-bedrooms').show();
        });
    });
    
    function getRooms(count_room) {
        let rooms = new Array(count_room); 
        for (let i = 0; i < count_room; i++) {
           rooms[i] = new Array($count_beds);
           for (let j = 0; j < $count_beds; j++) {
               rooms[i][$('#bed-' + i + '-' + j).data('bed-id')] = $('#bed-' + i + '-' + j).val(); 
           }
       }
        return rooms;
    }
    
   $('body').on('input', '.input-beds', function() { //Указываем кол-во максимальных мест по введенным кроватям для текущей спальни
     let num_rooms = $(this).data('room'); //номер спальни - i
     if (num_rooms == "" || num_rooms == undefined) num_rooms = 0;
     let count_user = 0;
     for (let j = 0; j < $count_beds; j++) { //кол-во кроватей * кол-во мест на кровати
         count_user += Number($("#bed-"+num_rooms+"-"+j).val()) * Number($("#bed-"+num_rooms+"-"+j).data('count'));
     }
     $("#counts-"+num_rooms).html(count_user);
   })
});
JS;


$this->registerJs($js);
$this->title = 'Спальные места ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

?>
<div class="bedrooms">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'stay_id')->textInput(['type' => 'hidden', 'id' => 'stay-id'])->label(false) ?>
<div class="card card-secondary">
    <div class="card-body">
        <div id="bedroom-list">
            <?= $this->render('_bedroom', [
                    'bedrooms' => $stay->bedrooms,
            ]) ?>
        </div>
        <span id="add-bedrooms" class="btn btn-primary">
            +
        </span>
    </div>
    <div class="form-group p-2">
        <?php
        if ($stay->filling) {
            echo Html::submitButton('Далее >>', ['class' => 'btn btn-primary']);
        } else {
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>