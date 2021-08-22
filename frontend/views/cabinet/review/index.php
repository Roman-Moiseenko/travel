<?php

/* @var $reviews \booking\entities\booking\BaseReview[] */

use booking\entities\Lang;
use yii\helpers\Url;
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->title = Lang::t('Мои отзывы');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="view-review">
    <?php foreach ($reviews as $review): ?>
        <div class="card mt-4 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col">

                        <div class="d-flex flex-row">
                            <div class="caption-list">
                                <a href="<?= $review->getLinks()['frontend'] ?>"><?= $review->getName(); ?></a>
                            </div>
                            <div class="align-self-center pl-4">
                                <?= \frontend\widgets\RatingWidget::widget([
                                    'rating' => $review->getVote()
                                ]) ?>
                            </div>
                            <div class="ml-auto align-self-center">

                                <a class="caption-list" href="<?= $review->getLinks()['update'] ?>"
                                   title="<?= Lang::t('Изменить') ?>" style="position: relative; z-index: 9999;"><i
                                            class="fas fa-pen"></i></a>
                                <a class="caption-list" href="<?= $review->getLinks()['remove'] ?>"
                                   title="<?= Lang::t('Удалить') ?>" style="position: relative; z-index: 9999;"><i
                                            class="far fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= $review->getText() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?= date('d-m-Y', $review->getDate()); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (count($reviews) == 0): ?>
        <h3><?= Lang::t('У вас нет отзывов') ?></h3>
    <?php endif; ?>
</div>
