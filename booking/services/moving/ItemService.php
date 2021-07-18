<?php


namespace booking\services\moving;


use booking\entities\Meta;
use booking\entities\moving\Item;
use booking\entities\moving\Page;
use booking\forms\moving\PageForm;
use booking\repositories\moving\ItemRepository;
use booking\repositories\moving\PageRepository;


class ItemService
{

    /**
     * @var ItemRepository
     */
    private $items;

    public function __construct(ItemRepository $items)
    {
        $this->items = $items;
    }

    public function create(ItemForm $form): Item
    {
        $parent = $this->items->get($form->parentId);
        $item = Item::create(
            $form->title,
            $form->slug,
            $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            ),
            $form->icon
            );
        $page->appendTo($parent);
        $this->pages->save($page);
        return $page;
    }

    public function edit($id, PageForm $form): void
    {
        $page = $this->pages->get($id);
        $this->assertIsNotRoot($page);
        $page->edit(
            $form->title,
            $form->slug,
            $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            ),
            $form->icon
        );
        if ($form->parentId !== $page->parent->id) {
            $parent = $this->pages->get($form->parentId);
            $page->appendTo($parent);
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
}