<?php


namespace booking\services\moving;


use booking\forms\forum\MessageForm;
use booking\forms\moving\ItemPostForm;
use booking\forms\user\SignupForm;
use booking\forms\user\UserCreateForm;
use booking\repositories\forum\PostRepository;
use booking\repositories\moving\ItemRepository;
use booking\repositories\user\UserRepository;
use booking\services\forum\PostService;
use booking\services\user\SignupService;
use booking\services\user\UserManageService;

class ItemPostService
{
    const EMAIL_BASE = '@bot.mail';
    const PHONE_BASE = '+7000';
    /**
     * @var UserManageService
     */
    private $userService;
    /**
     * @var PostService
     */
    private $postService;
    /**
     * @var ItemRepository
     */
    private $items;
    /**
     * @var PostRepository
     */
    private $posts;
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var SignupService
     */
    private $signupService;

    public function __construct(
        UserManageService $userService,
        SignupService $signupService,
        PostService $postService,
        ItemRepository $items,
        PostRepository $posts,
        UserRepository $users
    )
    {

        $this->userService = $userService;
        $this->postService = $postService;
        $this->items = $items;
        $this->posts = $posts;
        $this->users = $users;
        $this->signupService = $signupService;
    }

    public function addPost($item_id, ItemPostForm $form)
    {
        $item = $this->items->get($item_id);
        $post = $this->posts->get($item->post_id);
        $date = $post->update_at ?? $post->created_at + (3600 * 12 * rand(1, 3));
        //Создаем Пользователя
        $list = $this->users->getMask(['LIKE', 'email', self::EMAIL_BASE]); //найти последний email и phone ищем по телефону
        $number = str_pad(count($list) + 1, 7, '0', STR_PAD_LEFT);
        $form_user = new SignupForm();

        $form_user->email = $number . self::EMAIL_BASE;
        $form_user->username = self::PHONE_BASE . $number;
        $form_user->password = 'Foolprof77';
        $form_user->agreement = true;
        $form_user->policy = true;


        $user = $this->signupService->signup($form_user);
        $form_message = new MessageForm();
        $form_message->text = $form->message;
        $this->postService->addMessageOffice($item->post_id, $user->id, $date, $form_message);
    }
}