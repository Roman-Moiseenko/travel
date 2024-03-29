<?php


namespace frontend\widgets\reviews;

use booking\entities\moving\Page;

use booking\forms\CommentForm;

use booking\services\system\LoginService;
use yii\base\Widget;

class NewReviewMovingWidget extends Widget
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
        if ($this->loginService->isGuest()) return $this->render('auth', []);
        $reviewForm = new CommentForm();
        return $this->render('new-review-moving', [
            'reviewForm' => $reviewForm,
            'action' => ['/moving/moving/view', 'slug' => $this->page->slug],
        ]);


    }
}