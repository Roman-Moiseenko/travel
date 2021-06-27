<?php

use booking\forms\booking\trips\MealsForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $trip \booking\entities\booking\trips\Trip|null */
/* @var $placement \booking\entities\booking\trips\placement\Placement|null */
/* @var $model MealsForm */

$js = <<<JS
$(document).ready(
    function() {
    _x($('#mealsform-not_meals').is(':checked'));
    
    $('body').on('click', '#mealsform-not_meals', function() {
        _x($(this).is(':checked'));
    });
    
    function _x(_check) 
    {
        let _count = $('#mealsform-not_meals').data('count');
        for (let _i = 0; _i <_count; _i++) {
           $('#mealassignform-' + _i + '-cost').attr('readonly', _check);
            
        }
      console.log(_check);
    };
});
JS;
$this->registerJs($js);
$this->title = 'Питание для  ' . $placement->name;
$this->params['id'] = $trip->id;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/trips']];
$this->params['breadcrumbs'][] = ['label' => $trip->name, 'url' => ['/trip/common', 'id' => $trip->id]];
$this->params['breadcrumbs'][] = ['label' => 'Проживание', 'url' => ['/trip/placement/index', 'id' => $trip->id, 'placement_id' => $placement->id]];
$this->params['breadcrumbs'][] = ['label' => $placement->name, 'url' => ['/trip/placement/view', 'id' => $trip->id, 'placement_id' => $placement->id]];
$this->params['breadcrumbs'][] = 'Питание';
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<div class="card">
    <div class="card-body">
        <?= $form->field($model, 'not_meals')->checkbox(['data-count' => count($model->meals)])->label('Питание не предоставляется') ?>
        <tr id="look-meals">
            <table class="table table-striped" style="width: 600px !important;">
            <?php foreach ($model->meals as $i => $meal): ?>
            <tr>
                <td width="40px"><?= $meal->mark() ?></td>
                <td width="400px"><?= $meal->name() ?></td>
                <td width="160px">
                    <?= $form->field($meal, '['.$i.']cost')->textInput()->label(false) ?>
                </td>
                <td>руб</td>
            </tr>
            <?php endforeach; ?>
            </table>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    </div>

</div>


<?php ActiveForm::end(); ?>