<?php
declare(strict_types=1);

namespace booking\services\photos;

use booking\entities\Meta;
use booking\entities\photos\Item;
use booking\entities\photos\Page;
use booking\entities\photos\Tag;
use booking\forms\photos\ItemForm;
use booking\forms\photos\PageForm;
use booking\helpers\scr;
use booking\repositories\photos\PageRepository;
use booking\repositories\photos\TagRepository;
use booking\services\system\LoginService;
use booking\services\TransactionManager;

class PageService
{
    /**
     * @var PageRepository
     */
    private $pages;
    /**
     * @var TagRepository
     */
    private $tags;
    /**
     * @var TransactionManager
     */
    private $transaction;
    private $current_user;

    public function __construct(
        PageRepository     $pages,
        TagRepository      $tags,
        TransactionManager $transaction,
        LoginService       $loginService
    )
    {
        $this->pages = $pages;
        $this->tags = $tags;
        $this->transaction = $transaction;
        $this->current_user = $loginService->office()->getId();
    }

    public function create(PageForm $form): Page
    {
        $page = Page::create($this->current_user, $form->title, $form->description);
        $page->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));
        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $page->assignTag($tag->id);
        }

        $this->transaction->wrap(function () use ($page, $form) {
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tags->save($tag);
                }
                $page->assignTag($tag->id);
            }
            foreach ($form->tags->existing as $tag_id) {
                $page->assignTag($tag_id);
            }
            $this->pages->save($page);
        });

        return $page;
    }

    public function edit(int $id, PageForm $form): void
    {
        $page = $this->pages->get($id);
        $page->edit($form->title, $form->description);

        $page->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));

        $this->transaction->wrap(function () use ($page, $form) {
            $page->revokeTags();
            $this->pages->save($page);

            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = $this->tags->findByName($tagName)) {
                    $tag = Tag::create($tagName, $tagName);
                    $this->tags->save($tag);
                }
                $page->assignTag($tag->id);
            }
            foreach ($form->tags->existing as $tag_id) {
                $page->assignTag($tag_id);
            }
            $this->pages->save($page);
        });
    }

    public function activated($id): void
    {
        $page = $this->pages->get($id);
        $page->activate();
        $this->pages->save($page);
    }

    public function drafted($id): void
    {
        $page = $this->pages->get($id);
        $page->draft();
        $this->pages->save($page);
    }

    public function addItem($id, ItemForm $form): void
    {
        $page = $this->pages->get($id);
        $page->addItem(
            Item::create(
                $form->name,
                $form->description,
                $form->photo->files[0]
            )
        );
        $this->pages->save($page);
    }

    public function editItem($id, $item_id, ItemForm $form): void
    {
        $page = $this->pages->get($id);

        $page->editItem(
            $item_id,
            $form->name,
            $form->description,
            empty($form->photo->files) ? null : $form->photo->files[0]
        );

        $this->pages->save($page);
    }

    public function removeItem($id, $item_id): void
    {
        $page = $this->pages->get($id);
        $page->removeItem($item_id);
        $this->pages->save($page);
    }

    public function moveUpItem($id, $item_id): void
    {
        $page = $this->pages->get($id);
        $page->moveUpItem($item_id);
        $this->pages->save($page);
    }

    public function moveDownItem($id, $item_id): void
    {
        $page = $this->pages->get($id);
        $page->moveDownItem($item_id);
        $this->pages->save($page);
    }

    public function remove($id)
    {
        $page = $this->pages->get($id);
        $this->pages->remove($page);
    }
}