<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\shops\products\ReviewProduct;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use yii\base\Widget;

class NewReviewProductWidget extends Widget
{
    public $product_id = 0;

    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return '';
        }
        //Проверяем есть ли отзыв
        $user_id = \Yii::$app->user->id;
        $reviews = ReviewProduct::find()->andWhere(['user_id' => $user_id])->andWhere(['product_id' => $this->product_id])->all();
        if (count($reviews) != 0) return '';

        $reviewForm = new ReviewForm();

        return $this->render('new-review', [
            'reviewForm' => $reviewForm,
            'id' => $this->product_id,
            'action' => '/shop/product/' . $this->product_id,
        ]);
    }
}