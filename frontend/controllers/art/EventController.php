<?php


namespace frontend\controllers\art;


use booking\entities\Lang;
use booking\forms\moving\ReviewMovingForm;
use booking\forms\CommentForm;
use booking\helpers\StatusHelper;
use booking\repositories\art\event\CategoryRepository;
use booking\repositories\art\event\EventRepository;
use booking\repositories\moving\PageRepository;
use booking\services\art\event\EventService;
use booking\services\moving\PageManageService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;

class EventController extends Controller
{
    public $layout = 'main';//_art';

    /**
     * @var LoginService
     */
    private $loginService;
    /**
     * @var EventService
     */
    private $service;
    /**
     * @var CategoryRepository
     */
    private $categories;
    /**
     * @var EventRepository
     */
    private $events;

    private $test = true;

    public function __construct(
        $id,
        $module,
        LoginService $loginService,
        EventService $service,
        CategoryRepository $categories,
        EventRepository $events,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->loginService = $loginService;
        $this->service = $service;
        $this->categories = $categories;
        $this->events = $events;
    }

    public function actionIndex()
    {
        if ($this->test) if ($this->loginService->isGuest()) return $this->redirect(Url::to(['/']));

        //TODO получаем список всех событий
        $events = $this->events->getAll();
        $categories = $this->categories->getAll();
        return $this->render('index', [
            'categories' => $categories,
            'events' => $events,
            'currentCategory' => null,
        ]);
    }

    public function actionCategory($slug)
    {
        if ($this->test) if ($this->loginService->isGuest()) return $this->redirect(Url::to(['/']));

        $categories = $this->categories->getAll();
        $category = $this->categories->findBySlug($slug);
        $events = $this->events->getByCategory($category->id);
        if ($this->loginService->isGuest()) return $this->redirect(Url::to(['/']));
        return $this->render('index', [
            'categories' => $categories,
            'events' => $events,
            'currentCategory' => $category,
        ]);
    }

    public function actionEvent($slug)
    {
        if ($this->test) if ($this->loginService->isGuest()) return $this->redirect(Url::to(['/']));

        $event = $this->events->findBySlug($slug);
        return $this->render('event', [
            'event' => $event,
        ]);
    }

}