<?php


namespace booking\services\moving;


use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\moving\Item;
use booking\entities\moving\Page;
use booking\entities\moving\Photo;
use booking\forms\moving\ItemForm;
use booking\forms\moving\PageForm;
use booking\repositories\moving\ItemRepository;
use booking\repositories\moving\PageRepository;


class PageManageService
{

    /**
     * @var PageRepository
     */
    private $pages;
    /**
     * @var ItemRepository
     */
    private $items;

    public function __construct(PageRepository $pages, ItemRepository $items)
    {
        $this->pages = $pages;
        $this->items = $items;
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
            $form->icon
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
            $form->icon
        );
        if ($form->parentId !== $page->parent->id) {
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

    public function itemMoveDown($id, $item_id)
    {
        $page = $this->pages->get($id);
        $page->itemMoveDown($item_id);
        $this->pages->save($page);
    }

    public function itemMoveUp($id, $item_id)
    {
        $page = $this->pages->get($id);
        $page->itemMoveUp($item_id);
        $this->pages->save($page);
    }

    public function itemDelete($id, $item_id)
    {
        $page = $this->pages->get($id);
        $page->itemDelete($item_id);
        $this->pages->save($page);
    }

    public function removePhoto($id, $item_id, $photo_id)
    {
        $page = $this->pages->get($id);
        $item = $page->getItem($item_id);
        $item->removePhoto($photo_id);
        $item->save();
    }

    public function addItem($id, ItemForm $form)
    {
        $page = $this->pages->get($id);
        $item = $page->addItem(Item::create(
            $form->title,
            $form->text,
            new BookingAddress($form->address->address, $form->address->latitude, $form->address->longitude),
            $form->post_id
        ));
        $sort = $this->items->getMaxSort($page->id);
        $item->setSort($sort + 1);
        $this->pages->save($page);
        foreach ($form->photos->files as $photo) {
            $item->addPhoto(Photo::create($photo));
        }
        $item->save();
        return $item;
    }

    public function updateItem($id, $item_id, ItemForm $form): void
    {
        $page = $this->pages->get($id);
        $item = $page->getItem($item_id);
        $item->edit(
            $form->title,
            $form->text,
            new BookingAddress($form->address->address, $form->address->latitude, $form->address->longitude),
            $form->post_id
        );
        if ($form->photos->files) {
            foreach ($form->photos->files as $photo) {
                $item->addPhoto(Photo::create($photo));
            }
        }
        $item->save();
    }
}