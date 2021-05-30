<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\shops\products\ReviewProduct;
use booking\forms\booking\ReviewForm;
use booking\helpers\BookingHelper;
use booking\services\system\LoginService;
use yii\base\Widget;

class NewReviewProductWidget extends Widget
{
    public $product_id = 0;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(LoginService $loginService, $config = [])
    {
        parent::__construct($config);
        $this->loginService = $loginService;
    }

    public function run()
    {
        if ($this->loginService->isGuest()) return '';
        //Проверяем есть ли отзыв
        $user_id = $this->loginService->user()->id;
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