<?php


namespace frontend\controllers;


use booking\entities\forum\Category;
use booking\entities\forum\Message;
use booking\forms\forum\MessageForm;
use booking\forms\forum\PostForm;
use booking\helpers\scr;
use booking\helpers\SysHelper;
use booking\repositories\forum\PostRepository;
use booking\repositories\forum\SectionRepository;
use booking\services\ContactService;
use booking\services\forum\CategoryService;
use booking\services\forum\PostService;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;

class ForumController extends Controller
{
    public $layout = 'main';//_forum';
    /**
     * @var SectionRepository
     */
    private $sections;
    /**
     * @var CategoryService
     */
    private $categoryService;
    /**
     * @var PostService
     */
    private $postService;
    /**
     * @var PostRepository
     */
    private $posts;
    /**
     * @var LoginService
     */
    private $loginService;
    /**
     * @var ContactService
     */
    private $contact;

    public function __construct(
        $id,
        $module,
        SectionRepository $sections,
        CategoryService $categoryService,
        PostService $postService,
        PostRepository $posts,
        LoginService $loginService,
        ContactService $contact,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->sections = $sections;
        $this->categoryService = $categoryService;
        $this->postService = $postService;
        $this->posts = $posts;
        $this->loginService = $loginService;
        $this->contact = $contact;
    }

    public function actionIndex()
    {
        try {
            $sections = $this->sections->getAll();
        } catch (\Throwable $e) {
            $sections = [];
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->render('index', [
            'sections' => $sections,
        ]);
    }

    public function actionView($slug)
    {
        $section = $this->sections->findBySlug($slug);
        $posts = $this->posts->getBySection($section->id);
        $user = $this->loginService->user();
        return $this->render('section', [
            'section' => $section,
            'dataProvider' => $posts,
            'user' => $user,
        ]);
    }

    public function actionCategory($id)
    {
        $mobile = SysHelper::isMobile();
        $category = Category::findOne($id);
        $posts = $this->posts->getAll($category->id);
        $user = $this->loginService->user();
        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $posts,
            'user' => $user,
        ]);
    }

    public function actionPost($id)
    {
        $mobile = SysHelper::isMobile();
        try {
            $post = $this->posts->get($id);
            $messages = $this->posts->getMessages($post->id);
            /**** ПЕРЕДЕЛАТЬ  !!!!!!! **/
            $user = $this->loginService->user();
            if ($user) {
                $user->readForum($id);
                $user->save();
            }
            /** **************** **/
            $form = new MessageForm();
            if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
                try {
                    $message = $this->postService->addMessage($post->id, $form);
                    return $this->redirect(['forum/post', 'id' => $post->id, 'page' => $this->posts->getPage($post->id), '#' => $message->id]);
                } catch (\DomainException $e) {
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        catch (\Throwable $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['/about']);
        }
        return $this->render($mobile ? 'post_mobile' : 'post', [
            'post' => $post,
            'dataProvider' => $messages,
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionCreatePost($id)
    {
        /** $id - $category_id */
        $category = Category::findOne($id);
        $user = $this->loginService->user();

        $form = new PostForm($category->id);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $post = $this->postService->create($form);
                $this->contact->sendPostForum($post);
                return $this->redirect(['forum/post', 'id' => $post->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('post-create', [
            'category' => $category,
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionReplyMessage($id)
    {
        $user = $this->loginService->user();
        $replyMessage = Message::findOne($id);
        $post = $replyMessage->post;
        $form = new MessageForm($replyMessage->quote());
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $message = $this->postService->addMessage($post->id, $form);
                $this->contact->sendReplyForum($replyMessage->user, $message);
                return $this->redirect(['forum/post', 'id' => $post->id, 'page' => $this->posts->getPage($post->id), '#' => $message->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('post-update', [
            'post' => $replyMessage->post,
            'model' => $form,
            'user' => $user,
            'title' => 'Ответить с цитированием'
        ]);
    }


    public function actionRemovePost($id): \yii\web\Response
    {
        try {
            $this->postService->removePost($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
        //Проверка на права доступа - модератор
        // если автор, то есть ли сообщения других участников
    }

    public function actionFixPost($id): \yii\web\Response
    {
        try {
            $this->postService->fix($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnfixPost($id): \yii\web\Response
    {
        try {
            $this->postService->unFix($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionLockPost($id): \yii\web\Response
    {
        try {
            $this->postService->lock($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlockPost($id): \yii\web\Response
    {
        try {
            $this->postService->unLock($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUpdateMessage($id)
    {
        $user = $this->loginService->user();
        $message = Message::findOne($id);
        $form = new MessageForm($message);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->postService->editMessage($message->post_id, $message->id, $form);
                return $this->redirect(['forum/post', 'id' => $message->post_id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('post-update', [
            'post' => $message->post,
            'model' => $form,
            'user' => $user,
            'title' => 'Редактировать свое сообщение'
        ]);
    }

    public function actionRemoveMessage($id)
    {
        $message = Message::findOne($id);
        $post = $message->post;
        try {
            if ($post->count == 1) {
                $this->postService->removePost($post->id);
                return $this->redirect(Url::to(['forum/category', 'id' => $post->category_id]));
            } else {
                $this->postService->removeMessage($post->id, $id);
                return $this->redirect(\Yii::$app->request->referrer);
            }
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(\Yii::$app->request->referrer);
        }
    }
}