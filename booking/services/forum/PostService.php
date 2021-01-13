<?php


namespace booking\services\forum;


use booking\entities\admin\User;
use booking\entities\forum\Message;
use booking\entities\forum\Post;
use booking\forms\forum\MessageForm;
use booking\forms\forum\PostForm;
use booking\repositories\forum\PostRepository;

class PostService
{
    /**
     * @var PostRepository
     */
    private $posts;
    /**
     * @var CategoryService
     */
    private $service;

    public function __construct(PostRepository $posts, CategoryService $service)
    {
        $this->posts = $posts;
        $this->service = $service;
    }

    public function create(PostForm $form): Post
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumLock()) throw new \DomainException('У вас нет доступа для данного действия');
        $post = Post::create($form->category_id, $user->id, $form->caption);
        $message = Message::create($user->id, $form->message->text);
        $post->addMessage($message);
        $this->posts->save($post);
        $this->service->updated($post->category_id, $message);
        return $post;
    }

    public function lock($id)
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumUpdate()) {
            $post = $this->posts->get($id);
            $post->lock();
            $this->posts->save($post);
        } else {
            throw new \DomainException('У вас нет доступа для данного действия');
        }
    }

    public function fix($id)
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumUpdate()) {
            $post = $this->posts->get($id);
            $post->fixed();
            $this->posts->save($post);
        } else {
            throw new \DomainException('У вас нет доступа для данного действия');
        }
    }

    public function unFix($id)
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumUpdate()) {
            $post = $this->posts->get($id);
            $post->unFixed();
            $this->posts->save($post);
        } else {
            throw new \DomainException('У вас нет доступа для данного действия');
        }
    }

    public function unLock($id)
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumUpdate()) {
            $post = $this->posts->get($id);
            $post->unLock();
            $this->posts->save($post);
        } else {
            throw new \DomainException('У вас нет доступа для данного действия');
        }
    }

    public function addMessage($post_id, MessageForm $form)
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumLock()) throw new \DomainException('У вас нет доступа для данного действия');
        $post = $this->posts->get($post_id);
        $message = $post->addMessage(Message::create($user->id, $form->text));
        $this->posts->save($post);
        $this->service->updated($post->category_id, $message);
    }

    public function editMessage($post_id, $message_id, MessageForm $form)
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumLock()) throw new \DomainException('У вас нет доступа для данного действия');
        $post = $this->posts->get($post_id);
        if (!$post->isAuthor($message_id, $user->id)) throw new \DomainException('У вас нет прав изменять данное сообщение');
        $message = $post->editMessage($message_id, $form->text);
        $this->posts->save($post);
        $this->service->editUpdated($post->category_id, $message);
    }

    public function removeMessage($post_id, $message_id)
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumLock()) throw new \DomainException('У вас нет доступа для данного действия');
        $post = $this->posts->get($post_id);
        if (!$post->isAuthor($message_id, $user->id)) throw new \DomainException('У вас нет прав изменять данное сообщение');
        $post->removeMessage($message_id);
        $this->posts->save($post);
        $this->service->subUpdated($post->category_id);
    }

    public function removePost($id)
    {
        $user = User::findOne(\Yii::$app->user->id);
        if ($user->preferences->isForumAdmin()) {
            $post = $this->posts->get($id);
            $this->posts->remove($post);
        } else {
            throw new \DomainException('У вас нет доступа для данного действия');
        }
    }
}