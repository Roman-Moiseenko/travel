<?php


namespace booking\services\admin\forum;


use booking\entities\admin\forum\Category;
use booking\entities\admin\forum\Message;
use booking\forms\admin\forum\CategoryForm;
use booking\repositories\admin\forum\CategoryRepository;

class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function create(CategoryForm $form)
    {
        $maxSort = $this->categories->getMaxSort();
        $category = Category::create(
            $form->name,
            $form->description,
            $maxSort + 1
        );
        $this->categories->save($category);
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);
        $category->edit($form->name, $form->description);
        $this->categories->save($category);
    }

    public function moveUp($id)
    {
        $categories = $this->categories->getAll();
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
        $categories = $this->categories->getAll();
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

    public function updated($id, Message $message)
    {
        $category = $this->categories->get($id);
        $category->updated($message);
        $this->categories->save($category);
    }

    public function editUpdated($id, Message $message)
    {
        $category = $this->categories->get($id);
        $category->editUpdated($message);
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->categories->remove($category);
    }

    public function reload($id)
    {
        $category = $this->categories->get($id);
        $category->reCount();
        $this->categories->save($category);
    }

}