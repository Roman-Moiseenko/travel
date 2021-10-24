<?php


namespace frontend\widgets\reviews;

use booking\entities\medicine\Page;
use booking\forms\CommentForm;
use booking\services\system\LoginService;
use yii\base\Widget;

class NewReviewMedicineWidget extends Widget
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
        return $this->render('new-review-medicine', [
            'reviewForm' => $reviewForm,
            'action' => ['/medicine/medicine/view', 'slug' => $this->page->slug],
        ]);


    }
}