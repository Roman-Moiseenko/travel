<?php


/* @var $car Car */
/* @var $errors array */

use booking\entities\booking\cars\Car; ?>

<div class="row">
    <div class="col-5">
        <div class="form-group">
            <label>Кол-во авто</label>
            <input class="form-control" id="_count" type="number" min="1" max="<?= $car->quantity?>" value="<?= $car->quantity?>" width="100px" required>
        </div>
    </div>

    <div class="col-7">
        <div class="form-group">
            <label><Прокат></Прокат> в руб/сут</label>
            <input class="form-control" id="_cost" type="number" value="<?= $car->cost ?>" min="0"
                   step="50" width="100px" required>
        </div>
    </div>

</div>
    <div class="row">
        <div class="col-1">
            <a href="#" class="btn btn-success" id="send-new-car">Сохранить</a>
        </div>
    </div>
<?php if (isset($errors['new_car'])): ?>
<div class="row">
    <div class="col">
        <div class="error-message"><?= $errors['new_car'] ?></div>
    </div>
</div>
<?php endif; ?>
