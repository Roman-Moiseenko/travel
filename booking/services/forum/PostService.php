<?php


namespace booking\services\forum;


use booking\entities\user\User;
use booking\entities\forum\Message;
use booking\entities\forum\Post;
use booking\forms\forum\MessageForm;
use booking\forms\forum\PostForm;
use booking\repositories\forum\PostRepository;
use booking\services\forum\CategoryService;
use booking\services\system\LoginService;

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
    /**
     * @var LoginService
     */
    private $loginService;
    /** @var $admin User */
    private $user;

    public function __construct(
        PostRepository $posts,
        CategoryService $service,
        LoginService $loginService
    )
    {
        $this->posts = $posts;
        $this->service = $service;
        $this->loginService = $loginService;
        $this->user = $loginService->user();
    }

    public function create(PostForm $form): Post
    {
        $user = $this->user;
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
        $user = $this->user;
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
        $user = $this->user;
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
        $user = $this->user;
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
        $user = $this->user;
        if ($user->preferences->isForumUpdate()) {
            $post = $this->posts->get($id);
            $post->unLock();
            $this->posts->save($post);
        } else {
            throw new \DomainException('У вас нет доступа для данного действия');
        }
    }

    public function addMessage($post_id, MessageForm $form): Message
    {
        $user = $this->user;
        if ($user->preferences->isForumLock()) throw new \DomainException('У вас нет доступа для данного действия');
        $post = $this->posts->get($post_id);
        $message = $post->addMessage(Message::create($user->id, $form->text));
        $this->posts->save($post);
        $this->service->updated($post->category_id, $message);
        return $message;
    }

    public function editMessage($post_id, $message_id, MessageForm $form)
    {
        $user = $this->user;
        if ($user->preferences->isForumLock()) throw new \DomainException('У вас нет доступа для данного действия');
        $post = $this->posts->get($post_id);
        if (!$post->isAuthor($message_id, $user->id)) throw new \DomainException('У вас нет прав изменять данное сообщение');
        $message = $post->editMessage($message_id, $form->text);
        $this->posts->save($post);
        $this->service->editUpdated($post->category_id, $message);
    }

    public function removeMessage($post_id, $message_id)
    {
        $user = $this->user;
        if ($user->preferences->isForumLock()) throw new \DomainException('У вас нет доступа для данного действия');
        $post = $this->posts->get($post_id);
        if (!$post->isAuthor($message_id, $user->id)) throw new \DomainException('У вас нет прав изменять данное сообщение');
        $post->removeMessage($message_id);
        $this->posts->save($post);
        $this->service->reload($post->category_id);
    }

    public function removePost($id)
    {
        $user = $this->user;
        if ($user->preferences->isForumAdmin()) {
            $post = $this->posts->get($id);
            $this->posts->remove($post);
            $this->service->reload($post->category_id);
        } else {
            throw new \DomainException('У вас нет доступа для данного действия');
        }
    }
}