<?php


namespace frontend\widgets\design;


use booking\entities\Lang;
use yii\base\Widget;

class BtnConfirmation extends Widget
{
    public function run()
    {
        return $this->render('btn-confirmation',[
        ]);
    }
}

/* 1 вариант
<div class="form-group">
 *             <?= '' /*Html::submitButton(
                $tour->isConfirmation() ? Lang::t('Забронировать') : Lang::t('Приобрести'),
                [
                    'class' =>  'btn btn-lg btn-primary btn-block',
                    'disabled' => 'disabled',
                    'id' => 'button-booking-tour'
                ]<i class="far fa-calendar-plus"></i>
            ) ?>
 </div>

 *
*/