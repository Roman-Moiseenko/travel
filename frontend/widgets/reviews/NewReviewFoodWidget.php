<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\foods\ReviewFood;
use booking\forms\booking\ReviewForm;
use booking\forms\foods\ReviewFoodForm;
use booking\helpers\BookingHelper;
use yii\base\Widget;

class NewReviewFoodWidget extends Widget
{
    public $food_id = 0;

    public $reviewForm;
    public function run()
    {
                //$reviewForm = new ReviewFoodForm();
                return $this->render('new-review-food', [
                    'reviewForm' => $this->reviewForm,
                    'id' => $this->food_id,
                    //'action' => '/foods/food/view',
                ]);


    }
}