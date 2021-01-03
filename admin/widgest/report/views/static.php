<?php

/* @var $views integer */
/* @var $next_amount integer */
/* @var $last_tickets integer */
/* @var $last_amount integer */

use booking\entities\Currency;
use booking\helpers\CurrencyHelper; ?>

<div class="row">
    <div class="col-sm-3">
        <div class="info-box mb-3 bg-success">
            <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>
            <div lass="info-box-content">
                <span class="info-box-text">Предстоящие выплаты</span>
                <span class="info-box-number"><?= CurrencyHelper::stat($next_amount) ?></span>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="info-box mb-3 bg-gradient-blue">
            <span class="info-box-icon"><i class="fas fa-ticket-alt"></i></span>
            <div lass="info-box-content">
                <span class="info-box-text">Всего продано</span>
                <span class="info-box-number"><?= $last_tickets . ' шт.'?></span>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="info-box mb-3 bg-info">
            <span class="info-box-icon"><i class="fas fa-ruble-sign"></i></span>
            <div lass="info-box-content">
                <span class="info-box-text">Продано на сумму</span>
                <span class="info-box-number"><?= CurrencyHelper::stat($last_amount) ?></span>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="info-box mb-3 bg-warning">
            <span class="info-box-icon"><i class="fas fa-eye"></i></span>
            <div lass="info-box-content">
                <span class="info-box-text">Просмотров</span>
                <span class="info-box-number"><?= $views ?></span>
            </div>
        </div>
    </div>

</div>








