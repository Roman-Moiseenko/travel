<?php


namespace booking\repositories\booking\stays;

use booking\entities\booking\stays\Review;
use booking\entities\Lang;

class ReviewRepository
{

    public function get($id): Review
    {
        if (!$review = Review::findOne($id)) {
            throw new \DomainException(Lang::t('Отзыв не найден'));
        }
        return $review;
    }

    public function save(Review $review): void
    {
        if (!$review->save()) {
            throw new \RuntimeException(Lang::t('Отзыв не сохранен'));
        }
    }

    public function remove(Review $review)
    {
        if (!$review->delete()) {
            throw new \RuntimeException(Lang::t('Ошибка удаления отзыва'));
        }
    }
}