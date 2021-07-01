<?php


namespace booking\services\office\guides;


use booking\entities\forum\Section;
use booking\forms\office\guides\SectionForm;

use booking\repositories\forum\SectionRepository;

class ForumSectionService
{

    /**
     * @var SectionRepository
     */
    private $sections;

    public function __construct(SectionRepository $sections)
    {
        $this->sections = $sections;
    }

    public function create(SectionForm $form): Section
    {
        $section = Section::create($form->caption);
        $sort = $this->sections->getMaxSort();
        $section->setSort($sort + 1);
        $this->sections->save($section);
        return $section;
    }

    public function edit($id, SectionForm $form): void
    {
        $section = $this->sections->get($id);
        $section->edit($form->caption, $form->slug);
        $this->sections->save($section);
    }

    public function moveUp($id)
    {
        $sections = $this->sections->getAll();
        foreach ($sections as $i => $section) {
            if ($section->isFor($id) && $i != 0) {
                $t1 = $sections[$i - 1];
                $t2 = $section;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->sections->save($t1);
                $this->sections->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $sections = $this->sections->getAll();
        $maxSort = $this->sections->getMaxSort();
        foreach ($sections as $i => $section) {
            if ($section->isFor($id) && $i != count($sections) - 1) {
                $t1 = $section;
                $t2 = $sections[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->sections->save($t1);
                $this->sections->save($t2);
                return;
            }
        }
    }

    public function remove($id): void
    {
        $section = $this->sections->get($id);
        $this->sections->remove($section);
    }
}