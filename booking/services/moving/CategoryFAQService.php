<?php


namespace booking\services\moving;


use booking\entities\moving\CategoryFAQ;
use booking\forms\moving\CategoryFAQForm;
use booking\repositories\moving\CategoryFAQRepository;

class CategoryFAQService
{

    /**
     * @var CategoryFAQRepository
     */
    private $categoryFAQRepository;

    public function __construct(CategoryFAQRepository $categoryFAQRepository)
    {
        $this->categoryFAQRepository = $categoryFAQRepository;
    }

    public function create(CategoryFAQForm $form): CategoryFAQ
    {
        $category = CategoryFAQ::create($form->caption, $form->description);
        $sort = $this->categoryFAQRepository->getMaxSort();
        $category->setSort($sort + 1);
        $this->categoryFAQRepository->save($category);
        return $category;
    }

    public function edit($id, CategoryFAQForm $form): void
    {
        $category = $this->categoryFAQRepository->get($id);
        $category->edit($form->caption, $form->description);
        $this->categoryFAQRepository->save($category);
    }

    public function moveUp($id)
    {
        $types = $this->categoryFAQRepository->getAll();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != 0) {
                $t1 = $types[$i - 1];
                $t2 = $type;
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->categoryFAQRepository->save($t1);
                $this->categoryFAQRepository->save($t2);
                return;
            }
        }
    }

    public function moveDown($id)
    {
        $types = $this->categoryFAQRepository->getAll();
        $maxSort = $this->categoryFAQRepository->getMaxSort();
        foreach ($types as $i => $type) {
            if ($type->isFor($id) && $i != count($types) - 1) {
                $t1 = $type;
                $t2 = $types[$i + 1];
                $buffer = $t1->sort;
                $t1->setSort($t2->sort);
                $t2->setSort($buffer);
                $this->categoryFAQRepository->save($t1);
                $this->categoryFAQRepository->save($t2);
                return;
            }
        }
    }

    public function remove($id): void
    {
        $tourType = $this->categoryFAQRepository->get($id);
        $this->categoryFAQRepository->remove($tourType);
    }
}