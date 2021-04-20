<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\shops\products\ReviewProduct;
use booking\entities\shops\ReviewShop;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use yii\base\Widget;

class NewReviewShopWidget extends Widget
{
    public $shop_id = 0;

    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return '';
        }
        //Проверяем есть ли отзыв
        $user_id = \Yii::$app->user->id;
        $reviews = ReviewShop::find()->andWhere(['user_id' => $user_id])->andWhere(['shop_id' => $this->shop_id])->all();
        if (count($reviews) != 0) return '';

        $reviewForm = new ReviewForm();

        return $this->render('new-review', [
            'reviewForm' => $reviewForm,
            'id' => $this->shop_id,
            'action' => '/shop/' . $this->shop_id,
        ]);
    }
}