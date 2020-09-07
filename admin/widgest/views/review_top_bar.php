<?php

/* @var $reviews \booking\entities\booking\ReviewInterface[] */
/* @var $last_day int */
/* @var $count int */

use frontend\widgets\RatingWidget; ?>

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-warning navbar-badge"><?= $count?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <?php foreach ($reviews as $review):?>
        <a href="<?= $review->getLinks()['admin']?>" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                        <?= RatingWidget::widget(['rating' => $review->getVote()])?>
                    </h3>
                    <p class="text-sm"><?= $review->getName()?></p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?= date('d-m-Y', $review->getDate()) ?></p>
                </div>
            </div>
            <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <?php endforeach; ?>
        <?php if ($count > 5): ?>
        <a href="#" class="dropdown-item">
        <div class="media">...</div>
        </a>
        <?php endif; ?>
        <div class="dropdown-divider"></div>
        <span class="dropdown-item dropdown-footer">Отзывы за последние <?= $last_day ?> дней</span>
    </div>
</li>