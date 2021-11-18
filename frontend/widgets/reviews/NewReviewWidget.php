<?php


namespace frontend\widgets\reviews;

use booking\entities\moving\Page;

use booking\forms\CommentForm;

use booking\services\system\LoginService;
use yii\base\Widget;

class NewReviewWidget extends Widget
{
    /** @var $page Page */
    public $page;
    public $classReview;
    public $_id;
    public $_slug;
    public $path;
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
        $session = \Yii::$app->session;
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];
        $session->set('link', $url);
        if ($this->loginService->isGuest()) return $this->render('auth', ['url' => $url]);
        $reviewForm = new CommentForm();
        $action = '';
        if (!empty($this->_id)) $action = [$this->path, 'id' => $this->_id];
        if (!empty($this->_slug)) $action = [$this->path, 'slug' => $this->_slug];
        if (empty($action)) return 'Комментарии не подключены';
        return $this->render('_new_review', [
            'reviewForm' => $reviewForm,
            'action' => $action,
        ]);


    }
}