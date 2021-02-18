<?php


namespace booking\services\office\guides;


use booking\entities\booking\stays\nearby\NearbyCategory;
use booking\forms\office\guides\NearbyCategoryForm;
use booking\repositories\office\guides\NearbyCategoryRepository;

class NearbyCategoryService
{
    /**
     * @var NearbyCategoryRepository
     */
    private $categories;

    public function __construct(NearbyCategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function create(NearbyCategoryForm $form)
    {
        $category = NearbyCategory::create(
            $form->name,
            $form->group
        );
        $category->setSort($this->categories->getMaxSort($category->group) + 1);
        $this->categories->save($category);
    }

    public function edit($id, NearbyCategoryForm $form)
    {
        $category = $this->categories->get($id);
        $category->edit(
            $form->name,
            $form->group
        );
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->categories->remove($category);
    }

    public function moveUp($id)
    {
        $_category = $this->categories->get($id);
        $categories = $this->categories->getAllByGroup($_category->group);
        foreach ($categories as $i => $category) {
            if ($category->isFor($id) && $i != 0) {
                $t1 = $categories[$i - 1];
                $t2 = $category;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->categories->save($t1);
                $this->categories->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $_category = $this->categories->get($id);
        $categories = $this->categories->getAllByGroup($_category->group);
        foreach ($categories as $i => $category) {
            if ($category->isFor($id) && $i != count($categories) - 1) {
                $t1 = $category;
                $t2 = $categories[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->categories->save($t1);
                $this->categories->save($t2);
                return;
            }
        }
    }
}