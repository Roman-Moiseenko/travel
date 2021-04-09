<?php


namespace booking\forms\shops;


use booking\entities\shops\products\Photo;
use booking\entities\shops\products\Product;
use booking\entities\shops\products\Size;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * Class ProductForm
 * @package booking\forms\shops
 * @property SizeForm $size
 * @property PhotosForm $photo
 */
class ProductForm extends CompositeForm
{
    public $name;
    public $name_en;
    public $description;
    public $description_en;
    public $weight;

    public $article;
    public $collection;
    public $color;
    public $manufactured_id;
    public $category_id;
    public $cost;
    public $discount;

    public $deadline;
    public $request_available;

    public $materials = [];

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->name = $product->name;
            $this->name_en = $product->name_en;
            $this->description = $product->description;
            $this->description_en = $product->description_en;
            $this->weight = $product->weight;
            $this->size = new SizeForm($product->size);
            $this->article = $product->article;
            $this->collection = $product->collection;
            $this->color = $product->color;
            $this->manufactured_id = $product->manufactured_id;
            $this->category_id = $product->category_id;
            $this->cost = $product->cost;
            $this->discount = $product->discount;

            $this->deadline = $product->deadline;
            $this->request_available = $product->request_available;

            //TODO MaterialAssign
            $this->materials = ArrayHelper::getColumn($product->materialAssign, 'material_id');

        } else {
            $this->size = new SizeForm();
        }

        $this->photo = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'name_en', 'description', 'description_en', 'collection', 'article', 'color'], 'string'],
            [['weight', 'manufactured_id', 'category_id', 'cost', 'discount', 'deadline'], 'integer'],
            [['request_available'], 'boolean'],
            ['materials', 'each', 'rule' => ['integer']],
        ];
    }

    protected function internalForms(): array
    {
        return ['size', 'photo'];
    }
}