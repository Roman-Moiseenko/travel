<?php


namespace booking\services\office\guides;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort\ComfortCategory;
use booking\forms\office\guides\StayComfortCategoryForm;
use booking\forms\office\guides\StayComfortForm;
use booking\repositories\office\guides\StayComfortRepository;

class StayComfortService
{

    /**
     * @var StayComfortRepository
     */
    private $comforts;

    public function __construct(StayComfortRepository $comforts)
    {
        $this->comforts = $comforts;
    }

    public function create(StayComfortForm $form)
    {
        $comfort = Comfort::create(
            $form->category_id,
            $form->name,
            $form->paid,
            $form->featured,
            $form->photo
        );
        $comfort->setSort($this->comforts->getMaxSort() + 1);
        $this->comforts->save($comfort);
    }

    public function edit($id, StayComfortForm $form)
    {
        $comfort = $this->comforts->get($id);
        $comfort->edit(
            $form->category_id,
            $form->name,
            $form->paid,
            $form->featured,
            $form->photo
        );
        $this->comforts->save($comfort);
    }

    public function remove($id)
    {
        $comfort = $this->comforts->get($id);
        $this->comforts->remove($comfort);
    }

    public function moveUp($id)
    {
        $comforts = $this->comforts->getAll();
        foreach ($comforts as $i => $comfort) {
            if ($comfort->isFor($id) && $i != 0) {
                $t1 = $comforts[$i - 1];
                $t2 = $comfort;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->comforts->save($t1);
                $this->comforts->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $comforts = $this->comforts->getAll();
        foreach ($comforts as $i => $comfort) {
            if ($comfort->isFor($id) && $i != count($comforts) - 1) {
                $t1 = $comfort;
                $t2 = $comforts[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->comforts->save($t1);
                $this->comforts->save($t2);
                return;
            }
        }
    }

    public function createCategory(StayComfortCategoryForm $form)
    {
        $category = ComfortCategory::create(
            $form->name,
            $form->image
        );
        $category->setSort($this->comforts->getMaxSortCategory() + 1);
        $this->comforts->saveCategory($category);
    }

    public function editCategory($id, StayComfortCategoryForm $form)
    {
        $category = $this->comforts->getCategory($id);
        $category->edit(
            $form->name,
            $form->image
        );
        $this->comforts->saveCategory($category);
    }

    public function removeCategory($id)
    {
        $comfort = $this->comforts->getCategory($id);
        $this->comforts->removeCategory($comfort);
    }

    public function moveUpCategory($id)
    {
        $categories = $this->comforts->getAllCategory();
        foreach ($categories as $i => $category) {
            if ($category->isFor($id) && $i != 0) {
                $t1 = $categories[$i - 1];
                $t2 = $category;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->comforts->saveCategory($t1);
                $this->comforts->saveCategory($t2);
                return;
            }
        }
    }

    public function moveDownCategory($id)
    {
        $categories = $this->comforts->getAllCategory();
        foreach ($categories as $i => $category) {
            if ($category->isFor($id) && $i != count($categories) - 1) {
                $t1 = $category;
                $t2 = $categories[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->comforts->saveCategory($t1);
                $this->comforts->saveCategory($t2);
                return;
            }
        }
    }


}