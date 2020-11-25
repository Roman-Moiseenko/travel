<?php


namespace booking\services\office;


use booking\entities\admin\Help;
use booking\forms\HelpForm;
use booking\repositories\office\HelpRepository;

class HelpManageService
{

    /**
     * @var HelpRepository
     */
    private $pages;

    public function __construct(HelpRepository $pages)
    {
        $this->pages = $pages;
    }

    public function create(HelpForm $form): Help
    {
        $parent = $this->pages->get($form->parentId);
        $page = Help::create(
            $form->title,
            $form->content,
            $form->icon
        );
        $page->appendTo($parent);
        $this->pages->save($page);
        return $page;
    }

    public function edit($id, HelpForm $form): void
    {
        $page = $this->pages->get($id);
        //$this->assertIsNotRoot($page);
        $page->edit(
            $form->title,
            $form->content,
            $form->icon
        );
        if (!$page->isRoot()) {
            if ($form->parentId !== $page->parent->id) {
                $parent = $this->pages->get($form->parentId);
                $page->appendTo($parent);
            }
        }
        $this->pages->save($page);
    }

    public function moveUp($id): void
    {
        $page = $this->pages->get($id);
        $this->assertIsNotRoot($page);
        if ($prev = $page->prev) {
            $page->insertBefore($prev);
        }
        $this->pages->save($page);
    }

    public function moveDown($id): void
    {
        $page = $this->pages->get($id);
        $this->assertIsNotRoot($page);
        if ($next = $page->next) {
            $page->insertAfter($next);
        }
        $this->pages->save($page);
    }

    public function remove($id): void
    {
        $page = $this->pages->get($id);
        $this->assertIsNotRoot($page);
        $this->pages->remove($page);
    }

    private function assertIsNotRoot(Help $page): void
    {
        if ($page->isRoot()) {
            throw new \DomainException('Unable to manage the root page.');
        }
    }
}