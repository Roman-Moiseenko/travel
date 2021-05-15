<?php


namespace booking\services\moving;


use booking\entities\moving\FAQ;
use booking\entities\user\User;
use booking\forms\moving\AnswerForm;
use booking\forms\moving\QuestionForm;
use booking\repositories\moving\FAQRepository;
use booking\services\ContactService;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class FAQService
{

    /**
     * @var FAQRepository
     */
    private $repository;
    /**
     * @var ContactService
     */
    private $contactService;

    public function __construct(FAQRepository $repository, ContactService $contactService)
    {
        $this->repository = $repository;
        $this->contactService = $contactService;
    }

    public function question($category_id, QuestionForm $form)
    {
        $faq = FAQ::create(
            $form->username,
            $form->email,
            $category_id,
            $form->question
        );
        $this->repository->save($faq);
        $user = User::findByUsername(\Yii::$app->params['moving_moderator']);
        $this->contactService->sendNewQuestion($user->email, $faq);

    }

    public function answer(int $id, AnswerForm $form)
    {
        $faq = $this->repository->get($id);
        $faq->answer($form->answer);
        $this->repository->save($faq);
        if (!empty($faq->email)) {
            $this->contactService->sendNewAnswer($faq);
        }
    }
}