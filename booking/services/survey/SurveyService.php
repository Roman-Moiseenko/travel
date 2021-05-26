<?php


namespace booking\services\survey;


use booking\entities\Meta;
use booking\entities\survey\Survey;
use booking\forms\survey\SurveyForm;
use booking\repositories\survey\SurveyRepository;

class SurveyService
{
    /**
     * @var SurveyRepository
     */
    private $surveys;

    public function __construct(SurveyRepository $surveys)
    {
        $this->surveys = $surveys;
    }

    public function create(SurveyForm $form): Survey
    {
        $survey = Survey::create($form->caption);
        $survey->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));
        $this->surveys->save($survey);
        return $survey;
    }

    public function edit($id, SurveyForm $form): void
    {
        $survey = $this->surveys->get($id);
        $survey->edit($form->caption);
        $survey->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));
        $this->surveys->save($survey);
    }

    public function remove($id): void
    {
        $survey = $this->surveys->get($id);
        $this->surveys->remove($survey);
    }

    public function activate($id)
    {
        $survey = $this->surveys->get($id);
        $survey->activate();
        $this->surveys->save($survey);
    }

    public function draft($id)
    {
        $survey = $this->surveys->get($id);
        $survey->draft();
        $this->surveys->save($survey);
    }
}