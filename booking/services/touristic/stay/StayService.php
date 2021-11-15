<?php

namespace booking\services\touristic\stay;

use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\touristic\fun\Fun;
use booking\entities\touristic\fun\Photo;
use booking\entities\touristic\fun\ReviewFun;
use booking\entities\touristic\TouristicContact;
use booking\forms\touristic\fun\FunForm;

use booking\forms\booking\PhotosForm;
use booking\forms\booking\ReviewForm;
use booking\helpers\StatusHelper;
use booking\repositories\touristic\fun\CategoryRepository;
use booking\repositories\touristic\fun\FunRepository;
use booking\repositories\touristic\fun\ReviewFunRepository;

use booking\services\ContactService;
use booking\services\ImageService;

class StayService
{
    /**
     * @var FunRepository
     */
    private $funs;

    /**
     * @var ReviewFunRepository
     */
    private $reviews;
    /**
     * @var CategoryRepository
     */
    private $categories;
    /**
     * @var ContactService
     */
    private $contactService;


    public function __construct(
        FunRepository $funs,
        ReviewFunRepository $reviews,
        CategoryRepository $categories,
        ContactService $contactService
    )
    {
        $this->funs = $funs;
        $this->reviews = $reviews;

        $this->categories = $categories;
        $this->contactService = $contactService;
    }

    public function create(FunForm $form): Fun
    {
        $fun = Fun::create(
            $form->category_id,
            $form->name,
            $form->title,
            $form->slug,
            $form->description,
            $form->content,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            ),
            new TouristicContact(
                $form->contact->phone,
                $form->contact->url,
                $form->contact->email
            )
        );
        $sort = $this->funs->getMaxSort($fun->category_id);
        $fun->setSort($sort + 1);
        $this->funs->save($fun);
        return $fun;
    }

    public function edit($id, FunForm $form): void
    {
        $fun = $this->funs->get($id);
        $fun->edit(
            $form->category_id,
            $form->name,
            $form->title,
            $form->slug,
            $form->description,
            $form->content,
            new BookingAddress(
                $form->address->address,
                $form->address->latitude,
                $form->address->longitude
            ),
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            ),
            new TouristicContact(
                $form->contact->phone,
                $form->contact->url,
                $form->contact->email
            )
        );
        $this->funs->save($fun);
    }

    public function moveUp($category_id, $id)
    {
        $types = $this->funs->getAll($category_id);
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->funs->save($t1);
                $this->funs->save($t2);
                return;
            }
        }
    }

    public function moveDown($category_id, $id)
    {
        $types = $this->funs->getAll($category_id);
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->funs->save($t1);
                $this->funs->save($t2);
                return;
            }
        }
    }

    public function addPhotos($id, PhotosForm $form)
    {
        $fun = $this->funs->get($id);
        if ($form->files != null)
            foreach ($form->files as $file) {
                $fun->addPhoto(Photo::create($file));
                ImageService::rotate($file->tempName);
            }
        ini_set('max_execution_time', 180);
        $this->funs->save($fun);
        ini_set('max_execution_time', 30);
    }

    public function movePhotoUp($id, $photoId): void
    {
        $fun = $this->funs->get($id);
        $fun->movePhotoUp($photoId);
        $this->funs->save($fun);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $fun = $this->funs->get($id);
        $fun->movePhotoDown($photoId);
        $this->funs->save($fun);
    }

    public function removePhoto($id, $photoId): void
    {
        $fun = $this->funs->get($id);
        $fun->removePhoto($photoId);
        $this->funs->save($fun);
    }

    public function addReview($fun_id, $user_id, ReviewForm $form)
    {
        $fun = $this->funs->get($fun_id);
        $review = $fun->addReview(ReviewFun::create($user_id, $form->vote, $form->text));
        $this->funs->save($fun);
        $this->contactService->sendNoticeReview($review);
    }

    public function removeReview($review_id)
    {
        $review = $this->reviews->get($review_id);
        $fun = $this->funs->get($review->fun_id);
        $fun->removeReview($review_id);
        $this->funs->save($fun);
    }

    public function editReview($review_id, ReviewForm $form)
    {
        $review = $this->reviews->get($review_id);
        $fun = $this->funs->get($review->fun_id);
        $fun->editReview($review_id, $form->vote, $form->text);
        $this->funs->save($fun);
    }


    public function inactivated(int $id)
    {
        $fun = $this->funs->get($id);
        $fun->inactivated();
        $this->funs->save($fun);
    }

    public function activated(int $id)
    {
        $fun = $this->funs->get($id);
        $fun->activated();
        $this->funs->save($fun);
    }

    public function remove($id)
    {
        $fun = $this->funs->get($id);
        $this->funs->remove($fun);
    }


}