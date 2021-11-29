<?php


namespace booking\services\realtor;


use booking\entities\Meta;
use booking\entities\realtor\Page;
use booking\forms\realtor\PageForm;
use booking\repositories\realtor\PageRepository;


class PageManageService
{

    /**
     * @var PageRepository
     */
    private $pages;

    public function __construct(
        PageRepository $pages
    )
    {
        $this->pages = $pages;
    }

    public function create(PageForm $form): Page
    {
        $parent = $this->pages->get($form->parentId);
        $page = Page::create(
            $form->name,
            $form->title,
            $form->slug,
            $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            ),
            $form->icon,
            $form->description
        );
        if ($form->photo->files) {
            $page->setPhoto($form->photo->files[0]);
        }
        $page->appendTo($parent);
        $this->pages->save($page);
        return $page;
    }

    public function edit($id, PageForm $form): void
    {
        $page = $this->pages->get($id);
        $this->assertIsNotRoot($page);
        $page->edit(
            $form->name,
            $form->title,
            $form->slug,
            $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            ),
            $form->icon,
            $form->description
        );
        if ($form->parentId != $page->parent->id) {
            $parent = $this->pages->get($form->parentId);
            $page->appendTo($parent);
        }
        if ($form->photo->files) {
            $page->setPhoto($form->photo->files[0]);
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

    private function assertIsNotRoot(Page $page): void
    {
        if ($page->isRoot()) {
            throw new \DomainException('Unable to manage the root page.');
        }
    }

    public function activate($id): void
    {
        $page = $this->pages->get($id);
        $page->activate();
        $this->pages->save($page);
    }

    public function draft($id): void
    {
        $page = $this->pages->get($id);
        $page->draft();
        $this->pages->save($page);
    }
}