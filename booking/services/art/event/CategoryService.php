<?php


namespace booking\services\art\event;


use booking\entities\art\event\Category;
use booking\entities\Meta;
use booking\forms\art\event\CategoryForm;
use booking\repositories\art\event\CategoryRepository;


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

    public function create(CategoryForm $form): Category
    {
        $category = Category::create($form->name, $form->slug, $form->icon);
        $sort = $this->categories->getMaxSort();
        $category->setSort($sort + 1);
        $category->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));
        $this->categories->save($category);
        return $category;
    }

    public function edit(int $id, CategoryForm $form)
    {
        $category = $this->categories->get($id);
        $category->edit($form->name, $form->slug, $form->icon);
        $category->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));
        $this->categories->save($category);
    }

    public function remove($id)
    {
        $category = $this->categories->get($id);
        $this->categories->remove($category);
    }

    public function moveUp($id)
    {
        $types = $this->categories->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
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
        $types = $this->categories->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
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