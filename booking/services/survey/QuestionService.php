<?php


namespace booking\services\survey;


use booking\entities\survey\Question;
use booking\entities\survey\Variant;
use booking\forms\survey\QuestionForm;
use booking\forms\survey\VariantForm;
use booking\repositories\survey\QuestionRepository;

class QuestionService
{
    /**
     * @var QuestionRepository
     */
    private $questions;

    public function __construct(QuestionRepository $questions)
    {
        $this->questions = $questions;
    }

    public function create($id, QuestionForm $form): Question
    {
        $question = Question::create($id, $form->question);
        $sort = $this->questions->getMaxSort($id);
        $question->setSort($sort + 1);
        $this->questions->save($question);
        return $question;
    }

    public function edit($id, QuestionForm $form): void
    {
        $question = $this->questions->get($id);
        $question->edit($form->question);
        $this->questions->save($question);
    }

    public function addVariant($id, VariantForm $form): void
    {
        $question = $this->questions->get($id);
        $sort = count($question->variants);
        $question->addVariant(Variant::create($form->text, $sort + 1));
        $this->questions->save($question);
    }

    public function editVariant($id, VariantForm $form): void
    {
        $question = $this->questions->getByVariant($id);
        $question->editVariant($id, Variant::create($form->text));
        $this->questions->save($question);
    }

    public function removeVariant($id): void
    {
        $question = $this->questions->getByVariant($id);
        $question->removeVariant($id);
        $this->questions->save($question);
    }

    public function remove($id)
    {
        $question = $this->questions->get($id);
        $this->questions->remove($question);
    }

    public function moveUp($id)
    {
        $question = $this->questions->get($id);
        $questions = $this->questions->getBySurvey($question->survey_id);
        foreach ($questions as $i => $question) {
            if ($question->isFor($id) && $i > 0) {
                $t1 = $questions[$i - 1];
                $t2 = $question;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->questions->save($t1);
                $this->questions->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $question = $this->questions->get($id);
        $questions = $this->questions->getBySurvey($question->survey_id);
        /* @var  $questions  Question[] */
        foreach ($questions as $i => $question) {
            if ($question->isFor($id) && $i != count($questions) - 1) {
                $t1 = $question;
                $t2 = $questions[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->questions->save($t1);
                $this->questions->save($t2);
                return;
            }
        }
    }

    public function moveUpVariant($id)
    {
        $question = $this->questions->getByVariant($id);
        foreach ($question->variants as $i => $variant) {
            if ($variant->isFor($id) && $i > 0) {
                $t1 = $question->variants[$i - 1];
                $t2 = $variant;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $t1->save();
                $t2->save();
                //$this->questions->save($question);
                return;
            }
        }
    }

    public function moveDownVariant($id)
    {
        $question = $this->questions->getByVariant($id);
        foreach ($question->variants as $i => $variant) {
            if ($variant->isFor($id) && $i != count($question->variants) - 1) {
                $t1 = $variant;
                $t2 = $question->variants[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $t1->save();
                $t2->save();
                //$this->questions->save($question);
                return;
            }
        }
    }

}