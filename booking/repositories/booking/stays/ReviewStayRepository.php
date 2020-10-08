<?php


namespace booking\repositories\booking\stays;

use booking\entities\booking\stays\ReviewStay;
use booking\entities\Lang;

class ReviewStayRepository
{

    public function get($id): ReviewStay
    {
        if (!$review = ReviewStay::findOne($id)) {
            throw new \DomainException(Lang::t('Отзыв не найден'));
        }
        return $review;
    }

    public function save(ReviewStay $review): void
    {
        if (!$review->save()) {
            throw new \RuntimeException(Lang::t('Отзыв не сохранен'));
        }
    }

    public function remove(ReviewStay $review)
    {
        if (!$review->delete()) {
            throw new \RuntimeException(Lang::t('Ошибка удаления отзыва'));
        }
    }
}