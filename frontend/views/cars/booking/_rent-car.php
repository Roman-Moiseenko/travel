<?php

/* @var $rent_car array */

use booking\entities\booking\cars\CostCalendar;
use booking\entities\Lang;
use booking\helpers\CurrencyHelper;

?>
    <!-- КОЛ-ВО -->
    <div class="row pt-2 pb-2">
        <div class="col-5 pr-1">
            <b><?= Lang::t('Кол-во') ?>:</b>
        </div>
        <div class="col-4 px-1">
            <input class="count-car form-control" id="count-car" name="count-car" type="number" min="1" value="1"
                   max="<?= $rent_car['max_avto'] ?>"/>
        </div>
    </div>
    <!-- ДОСТАВКА -->
<?php if ($rent_car['delivery']): ?>
    <div class="row pt-2 pb-2">
        <div class="col">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" id="delivery" type="checkbox" value="1">
                <label class="custom-control-label" for="delivery">Доставка до адресата</label>
            </div>
        </div>
    </div>
    <div id="show_comment" style="display: none">
        <div class="row pt-2 pb-2">
            <div class="col-11">
                <div class="custom-control custom-checkbox pl-0">
                    <label class="" for="comment">Укажите адрес и время доставки</label>
                    <textarea class="form-control" id="comment" style="resize: none;"></textarea>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
    <!-- ИТОГО -->
    <div id="rent-car-amount"></div>
    <!-- ОШИБКИ -->
<?php if (isset($rent_car['error'])): ?>
    <div class="row pb-2">
        <div class="col">
            <div id="errors" class="errors-cars"><?= $rent_car['error'] ?></div>
        </div>
    </div>
<?php endif; ?>