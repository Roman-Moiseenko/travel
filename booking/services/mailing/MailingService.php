<?php


namespace booking\services\mailing;


use booking\entities\blog\post\Post;
use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\stays\Stay;
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

    //TODO ** BOOKING_OBJECT **

    public function createTours():? Mailing
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEW_TOURS);
        $tours = Tour::find()->active()->andWhere(['>=', 'public_at', $mailing_last_at])->all();
        //Создаем сообщение
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
        $stays = Stay::find()->active()->andWhere(['>=', 'public_at', $mailing_last_at])->all();
        //Создаем сообщение
        if (count($stays) == 0) return null;
        $subject = '<h1>Обзор новых апартаментов целиком</h1>';
        foreach ($stays as $stay) {
            $row = ' <img src="' . $stay->mainPhoto->getThumbFileUrl('file', 'cabinet_list'). '"> <span style="font-size: 16px">' .
                Html::a($stay->name, \Yii::$app->params['frontendHostInfo'] . '/tour/'. $stay->id) .
                ' от ' . $stay->legal->caption . '</span><br>';
            $subject .= $row;
        }
        $mailing = Mailing::create(Mailing::NEW_STAYS, $subject);
        $this->mailings->save($mailing);
        return $mailing;
    }

    public function createCars():? Mailing
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEW_CARS);
        $cars = Car::find()->active()->andWhere(['>=', 'public_at', $mailing_last_at])->all();
        //Создаем сообщение
        if (count($cars) == 0) return null;
        $subject = '<h1>Обзор новых туров, экскурсий за неделю</h1>';
        foreach ($cars as $car) {
            $row = ' <img src="' . $car->mainPhoto->getThumbFileUrl('file', 'cabinet_list'). '"> <span style="font-size: 16px">' .
                Html::a($car->name, \Yii::$app->params['frontendHostInfo'] . '/car/'. $car->id) .
                ' от ' . $car->legal->caption . '</span><br>';
            $subject .= $row;
        }
        $mailing = Mailing::create(Mailing::NEW_CARS, $subject);
        $this->mailings->save($mailing);
        return $mailing;
    }

    public function createFuns():? Mailing
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEW_FUNS);
        $funs = Fun::find()->active()->andWhere(['>=', 'public_at', $mailing_last_at])->all();
        //Создаем сообщение
        if (count($funs) == 0) return null;
        $subject = '<h1>Обзор новых развлечений и мероприятий за неделю</h1>';
        foreach ($funs as $fun) {
            $row = ' <img src="' . $fun->mainPhoto->getThumbFileUrl('file', 'cabinet_list'). '"> <span style="font-size: 16px">' .
                Html::a($fun->name, \Yii::$app->params['frontendHostInfo'] . '/fun/'. $fun->id) .
                ' от ' . $fun->legal->caption . '</span><br>';
            $subject .= $row;
        }
        $mailing = Mailing::create(Mailing::NEW_FUNS, $subject);
        $this->mailings->save($mailing);
        return $mailing;
    }

    public function createBlog()
    {
        $mailing_last_at = $this->mailings->getLast(Mailing::NEWS_BLOG);
        $posts = Post::find()->active()->andWhere(['>=', 'public_at', $mailing_last_at])->all();
        //Создаем сообщение
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