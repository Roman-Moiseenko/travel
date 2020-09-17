<?php

use booking\entities\booking\tours\Tour;

/* @var $tour Tour */

?>

<div class="row">
    <div class="col-2">
        <div class="form-group">
            <label>Начало</label>
            <input class="form-control" id="_time" type="time" width="100px" value="00:00" required>
        </div>
    </div>
    <div class="col-1">
        <div class="form-group">
            <label>Билеты</label>
            <input class="form-control" id="_tickets" type="number" min="1" value="1" width="100px" required>
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label>Цена за взрослый билет</label>
            <input class="form-control" id="_adult" type="number" value="<?= $tour->baseCost->adult ?>" min="0"
                   step="50" width="100px" required>
        </div>
    </div>
    <?php if ($tour->baseCost->child != null): ?>
        <div class="col-3">
            <div class="form-group">
                <label>Цена за детский билет</label>
                <input class="form-control" id="_child" type="number" value="<?= $tour->baseCost->child ?>" min="0"
                       step="50" width="100px">
            </div>
        </div>
    <?php endif; ?>

    <?php if ($tour->baseCost->preference != null): ?>
        <div class="col-3">
            <div class="form-group">
                <label>Цена за льготный билет</label>
                <input class="form-control" id="_preference" type="number" value="<?= $tour->baseCost->preference ?>"
                       min="0" step="50" width="100px">
            </div>
        </div>
    <?php endif; ?>
</div>
    <div class="row">
        <div class="col-1">
            <a href="#" class="btn btn-success" id="send-new-tour">Добавить</a>
        </div>
    </div>
