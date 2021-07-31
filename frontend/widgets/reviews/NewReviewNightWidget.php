<?php


namespace frontend\widgets\reviews;

use booking\entities\booking\tours\BookingTour;
use booking\entities\booking\tours\ReviewTour;
use booking\entities\moving\Page;
use booking\entities\moving\ReviewMoving;
use booking\forms\booking\ReviewForm;
use booking\forms\moving\ReviewMovingForm;
use booking\forms\CommentForm;
use booking\helpers\BookingHelper;
use booking\services\system\LoginService;
use yii\base\Widget;

class NewReviewNightWidget extends Widget
{
    /** @var $page Page */
    public $page;
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
        //$test =  ?? false;
        if ($this->loginService->isGuest()) return '';
        $reviewForm = new CommentForm();
        return $this->render('new-review-night', [
            'reviewForm' => $reviewForm,
            'action' => ['/night/night/view', 'slug' => $this->page->slug],
        ]);


    }
}