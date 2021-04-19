<?php


namespace frontend\widgets\shop;


use booking\entities\shops\products\AdProduct;
use booking\entities\shops\products\Category;
use booking\entities\shops\products\Product;
use booking\repositories\shops\CategoryRepository;
use yii\base\Widget;
use yii\helpers\Html;

class CategoriesWidget extends Widget
{
    /** @var $active Category|null */
    public $active;
    public $sub = false;
    private $categories;
    public $showcount = false;

    public function __construct(CategoryRepository $categories, $config = [])
    {

        /**
         *  Инклюдим систему поиска
         */
        $this->categories = $categories;
        parent::__construct($config);
    }

    public function run()
    {
        /**
         * Ищем кол-во товаров по категории из системы поиска
         */
        return Html::tag('div', implode(PHP_EOL, array_map(function (Category $category) {
            $indent = ($category->depth > 1 ? str_repeat('&nbsp;&nbsp;&nbsp;', $category->depth - 1) . '- ' : '');
            $active = $this->active && ($this->active->id == $category->id || $this->active->isChildOf($category));
            $count = '';
            if ($this->showcount) {
                $categories_id = array_merge([$category->id], $category->getLeaves()->select('id')->column());
                $count = ' (' .
                    Product::find()->active()->andWhere(['category_id' => $categories_id])->count().
                    ')';
            }
            return Html::a(
                $indent . Html::encode($category->name) . $count,
                ['/shop/catalog/category', 'id' => $category->id],
                ['class' => $active ? 'list-group-item active' : 'list-group-item']
            );
        }, $this->categories->getTreeWithSubsOf($this->active, $this->sub))), [
            'class' => 'list-group',
        ]);
    }
}