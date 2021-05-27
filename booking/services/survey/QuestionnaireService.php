<?php


namespace booking\services\survey;


use booking\entities\survey\Answer;
use booking\entities\survey\Questionnaire;
use booking\forms\survey\QuestionnaireForm;
use booking\repositories\survey\QuestionnaireRepository;
use booking\services\user\UserIdentity;

class QuestionnaireService
{

    /**
     * @var QuestionnaireRepository
     */
    private $questionnaires;
    /**
     * @var UserIdentity
     */
    private $identity;

    public function __construct(QuestionnaireRepository $questionnaires, UserIdentity $identity)
    {
        $this->questionnaires = $questionnaires;
        $this->identity = $identity;
    }

    public function checkSurvey($survey_id):? Questionnaire
    {
        $user_cookie = $this->identity->loadUser();
        if (empty($user_cookie)) return null;
        $questionnaires = $this->questionnaires->getByUser($survey_id, $user_cookie);
        return $questionnaires;

    }

    public function create(QuestionnaireForm $form): void
    {
        $questionnaire = Questionnaire::create($this->identity->createUser(), $form->survey_id);
        foreach ($form->questions as $question_id => $values_id)
            $questionnaire->addAnswer(Answer::create($question_id, $values_id));
        $this->questionnaires->save($questionnaire);
    }

}