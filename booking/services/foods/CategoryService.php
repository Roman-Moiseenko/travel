<?php


namespace booking\services\foods;


use booking\entities\foods\Category;
use booking\forms\foods\CategoryForm;
use booking\repositories\foods\CategoryRepository;

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
        $category = Category::create($form->name);
        $this->categories->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = Category::create($form->name);
        $category->edit($form->name);
        $this->categories->save($category);
    }
    public function remove($id): void
    {
        $category = $this->categories->get($id);
        $this->categories->remove($category);
    }
}