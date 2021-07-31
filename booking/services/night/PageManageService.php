<?php


namespace booking\services\night;


use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\night\Page;
use booking\entities\night\ReviewNight;
use booking\forms\night\PageForm;
use booking\forms\CommentForm;

use booking\repositories\night\PageRepository;
use booking\repositories\night\ReviewNightRepository;


class PageManageService
{

    /**
     * @var PageRepository
     */
    private $pages;
    /**
     * @var ReviewNightRepository
     */
    private $reviews;

    public function __construct(
        PageRepository $pages,
        ReviewNightRepository $reviews
    )
    {
        $this->pages = $pages;
        $this->reviews = $reviews;
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

    public function addReview($page_id, $user_id, CommentForm $form)
    {
        $page = $this->pages->get($page_id);
        $page->addReview(ReviewNight::create($user_id, $form->text));
        $this->pages->save($page);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $page = $this->pages->get($review->page_id);
        $page->removeReview($review_id);
        $this->pages->save($page);
    }
}