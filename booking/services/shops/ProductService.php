<?php


namespace booking\services\shops;


use booking\entities\Meta;
use booking\entities\shops\products\BaseProduct;
use booking\entities\shops\products\Photo;
use booking\entities\shops\products\Product;
use booking\entities\shops\products\Size;
use booking\forms\shops\ProductForm;
use booking\repositories\shops\ProductRepository;

class ProductService
{

    /**
     * @var ProductRepository
     */
    private $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function create($shop_id, ProductForm $form): Product
    {
        $product = Product::create(
            $form->name,
            $form->name_en,
            $form->description,
            $form->description_en,
            $form->weight,
            Size::create(
                $form->size->width,
                $form->size->height,
                $form->size->depth
            ),
            $form->article,
            $form->collection,
            $form->color,
            $form->manufactured_id,
            $form->category_id,
            $form->cost,
            $form->discount,
            $form->deadline,
            $form->request_available
        );
        $product->shop_id = $shop_id;
//        $this->products->save($product);
//        $product->clearMaterial();
        foreach ($form->photo->files as $file){
            $product->addPhoto(Photo::create($file));
        }

        foreach ($form->materials as $material) {
            $product->assignMaterial($material);
        }

        $product->setMeta(new Meta());
        $this->products->save($product);
        return $product;
    }

    public function edit($product_id, ProductForm $form): void
    {

    }
}