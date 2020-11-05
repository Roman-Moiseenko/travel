<?php


namespace booking\services\mailing;


use booking\entities\blog\post\Post;
use booking\entities\booking\tours\Tour;
use booking\entities\mailing\Mailing;
use booking\forms\MailingForm;
use booking\repositories\mailing\MailingRepository;
use booking\services\ContactService;
use yii\helpers\Html;
use yii\helpers\Url;

class MailingService
{
    /**
     * @var MailingRepository
     */
    private $mailings;
    /**
     * @var ContactService
     */
    private $contact;
    /**
     * @var \booking\repositories\user\UserRepository
     */
    private $clients;
    /**
     * @var \booking\repositories\admin\UserRepository
     */
    private $providers;

    public function __construct(
        MailingRepository $mailings,
        ContactService $contact,
        \booking\repositories\user\UserRepository $clients,
        \booking\repositories\admin\UserRepository $providers)
    {
        $this->mailings = $mailings;
        $this->contact = $contact;
        $this->clients = $clients;
        $this->providers = $providers;
    }

    public function create(MailingForm $form): Mailing
    {
        $mailing = Mailing::create($form->theme, $form->subject);
        $this->mailings->save($mailing);
        return $mailing;
    }

    public function edit($id, MailingForm $form): void
    {
        $mailing = $this->mailings->get($id);
        $mailing->edit($form->theme, $form->subject);
        $this->mailings->save($mailing);
    }

    public function remove($id): void
    {
        $mailing = $this->mailings->get($id);
        $this->mailings->remove($mailing);
    }

    public function send($id): bool
    {
        $emails = [];
        $mailing = $this->mailings->get($id);
        //по типу рассылки ищем адреса
        switch ($mailing->theme) {
            case Mailing::NEWS_PROVIDER:
                $emails = $this->providers->getAllEmail();
                break;
            case Mailing::NEWS:
                $emails = $this->clients->getAllEmail();
                break;
            default:
                $emails = $this->clients->getAllEmail($mailing->theme);
        }
        //отправляем письма
        $this->contact->sendMailing($mailing, $emails);
        $mailing->send();
        $this->mailings->save($mailing);
        return true;
    }

    public function createTours():? Mailing
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEW_TOURS);
        /** @var Tour[] $tours */
        $tours = Tour::find()->active()->andWhere(['>=', 'public_at', $mailing_last_at])->all();
        //Создаем сообщение
        //echo count($tours);
        if (count($tours) == 0) return null;
        $subject = '<h1>Обзор новых туров, экскурсий за неделю</h1>';
        foreach ($tours as $tour) {
            $row = ' <img src="' . $tour->mainPhoto->getThumbFileUrl('file', 'cabinet_list'). '"> <span style="font-size: 16px">' .
                Html::a($tour->name, \Yii::$app->params['frontendHostInfo'] . '/tour/'. $tour->slug) .
                ' от ' . $tour->legal->caption . '</span><br>';
            $subject .= $row;
        }
        $mailing = Mailing::create(Mailing::NEW_TOURS, $subject);
        $this->mailings->save($mailing);
        return $mailing;
    }

    public function createStays():? Mailing
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEW_STAYS);
        //TODO Заглушка Рассылки
    }

    public function createCars():? Mailing
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEW_CARS);
        //TODO Заглушка Рассылки
    }

    public function createFuns():? Mailing
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEW_FUNS);
        //TODO Заглушка Рассылки
    }

    public function createBlog()
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEWS_BLOG);
        $posts = Post::find()->active()->andWhere(['>=', 'public_at', $mailing_last_at])->all();

        //Создаем сообщение
        //echo count($posts);
        if (count($posts) == 0) return null;
        $subject = '<h1>Обзор новых записей в блоге</h1>';
        foreach ($posts as $post) {
            $row = '<img src="' . $post->getThumbFileUrl('photo', 'admin'). '"> <span style="font-size: 16px">' .
                Html::a($post->title, \Yii::$app->params['frontendHostInfo'] . '/post/'. $post->id) . '</span><br>' . $post->description . '<br><br>';
            $subject .= $row;
        }
        $mailing = Mailing::create(Mailing::NEWS_BLOG, $subject);
        $this->mailings->save($mailing);
        return $mailing;
    }
}