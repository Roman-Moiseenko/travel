<?php


namespace booking\services\blog;


use booking\entities\blog\Category;
use booking\entities\Meta;
use booking\forms\blog\CategoryForm;
use booking\repositories\blog\CategoryRepository;
use booking\repositories\blog\PostRepository;

class CategoryManageService
{
    private $categories;
    /**
     * @var PostRepository
     */
    private $posts;

    public function __construct(CategoryRepository $categories, PostRepository $posts)
    {
        $this->categories = $categories;
        $this->posts = $posts;
    }

    public function create(CategoryForm $form): Category
    {
        $category = Category::create(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            $form->sort,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            ),
            $form->name_en,
            $form->title_en,
            $form->description_en
        );
        $this->categories->save($category);
        return $category;
    }

    public function edit($id, CategoryForm $form)
    {
        $category = $this->categories->get($id);
        $category->edit(
            $form->name,
            $form->slug,
            $form->title,
            $form->description,
            $form->sort,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            ),
            $form->name_en,
            $form->title_en,
            $form->description_en
            );
        $this->categories->save($category);
    }

    public function remove($id): void
    {
        $category = $this->categories->get($id);
        if ($this->posts->existsByCategory($category->id)) {
            throw new \DomainException('Нельзя удалить категорию с постами.');
        }
        $this->categories->remove($category);
    }
}