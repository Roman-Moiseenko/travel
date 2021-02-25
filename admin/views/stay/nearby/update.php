<?php

use booking\entities\booking\stays\nearby\NearbyCategory;use booking\entities\booking\stays\Stay;

use booking\forms\booking\stays\StayNearbyForm;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model StayNearbyForm */
/* @var $stay Stay */

$js = <<<JS
$(document).ready(function() {
    $('body').on('click', '.add-nearby', function() {
        let stay_id = $('#stay-id').val();
        let category_id = $(this).data('category');
        let nearby = getNearby(category_id);
        $.post('/stay/nearby/add', {stay_id: stay_id, category_id: category_id, nearby: nearby, status: "add"}, function(data) {
            $('#list-nearby-' + category_id).html(data);
            
        });
    });
    
    $('body').on('click', '.sub-nearby', function() {
        let stay_id = $('#stay-id').val();
        let category_id = $(this).data('category');
        let nearby = getNearby(category_id);
        let del_nearby = $(this).data('i');
        nearby.splice(del_nearby, 1);        
        $.post('/stay/nearby/add', {stay_id: stay_id, category_id: category_id, nearby: nearby, status: "sub"}, function(data) {
            $('#list-nearby-' + category_id).html(data);
        });
    });    

    function getNearby(category_id) {
        let count_nearby = $('#count-nearby-' + category_id).val();
        let nearby = new Array();
        for (let i = 0; i < count_nearby; i++) {
            nearby[i] = [
                $('#nearby-name-' + category_id + '-' + i).val(), 
                $('#nearby-distance-' + category_id + '-' + i).val(), 
                $('#nearby-unit-' + category_id + '-' + i).val()                
                ];
        }  
        return nearby;
    }
});
JS;
$this->registerJs($js);

$this->title = 'В окрестностях ' . $stay->name;
$this->params['id'] = $stay->id;
$this->params['breadcrumbs'][] = ['label' => 'Мое жилье', 'url' => ['/stays']];
$this->params['breadcrumbs'][] = ['label' => $stay->name, 'url' => ['/stay/common', 'id' => $stay->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="nearby">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
    ]); ?>
    <?= $form->field($model, 'stay_id')->textInput(['type' => 'hidden', 'id' => 'stay-id'])->label(false) ?>
    <?php foreach (NearbyCategory::listGroup() as $group => $name): ?>
    <div class="card card-secondary">
        <div class="card-header"><?= $name ?></div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php foreach (NearbyCategory::getCategories($group) as $category): ?>
                    <div>
                        <label><?= $category->name ?>:</label>
                        <div id="list-nearby-<?= $category->id ?>">
                            <?= $this->render('_nearby_list', [
                                    'nearby' => $stay->getNearbyByCategory($category->id),
                                    'category_id' => $category->id,
                            ]) ?>

                        </div>
                        <span class="btn add-nearby" style="color: #0c525d" data-category="<?= $category->id ?>"><i class="far fa-plus-square"></i> Добавить</span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
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

