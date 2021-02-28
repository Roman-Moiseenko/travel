<?php

use booking\entities\booking\stays\CustomServices;
use booking\entities\booking\stays\nearby\Nearby;

/* @var $services CustomServices[] */

if (count($services) == 0) $services[] = CustomServices::create('', 0, 0);

?>
<input type="hidden" id="count-services" value="<?= count($services) ?>">
<?php foreach ($services as $i => $item): ?>
    <div class="row" id="item-nearby-<?= $i ?>">
        <div class="col-sm-6">
            <label>Услуга:</label>
            <input class="form-control" id="services-name-<?= $i ?>" name="CustomServicesForm[<?= $i ?>][name]"
                   value="<?= $item->name ?>">
        </div>
        <div class="col-sm-3">
            <label>Стоимость:</label>
            <div class="d-flex">
                <div>
                    <input class="form-control" id="services-value-<?= $i ?>"
                           type="number" min="0"
                           name="CustomServicesForm[<?= $i ?>][value]" value="<?= $item->value ?>"
                           style="width: 100px !important;">
                </div>
                <div class="form-group">
                    <select class="form-control" id="services-payment-<?= $i ?>" name="CustomServicesForm[<?= $i ?>][payment]">
                        <option value="0"></option>
                        <?php foreach (CustomServices::listPayment() as $j => $payment): ?>
                        <option value="<?= $j ?>" <?= $item->payment == $j ? 'selected' : ''?>><?= CustomServices::listPayment()[$j] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="pl-3 align-items-end">
                    <span class="sub-services btn btn-sm btn-warning align-bottom" data-i="<?= $i ?>">x</span>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
