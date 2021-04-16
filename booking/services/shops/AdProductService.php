<?php


namespace booking\services\shops;


use booking\entities\Meta;
use booking\entities\shops\products\AdPhoto;
use booking\entities\shops\products\AdProduct;
use booking\entities\shops\products\BaseProduct;
use booking\entities\shops\products\Photo;
use booking\entities\shops\products\Product;
use booking\entities\shops\products\Size;
use booking\forms\shops\AdProductForm;
use booking\forms\shops\CostModalForm;
use booking\forms\shops\ProductForm;
use booking\repositories\shops\ProductRepository;

class AdProductService
{

    /**
     * @var ProductRepository
     */
    private $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function create($shop_id, AdProductForm $form): AdProduct
    {
        $product = AdProduct::create(
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
            $form->discount
        );
        $product->shop_id = $shop_id;

        foreach ($form->photo->files as $file){
            $product->addPhoto(AdPhoto::create($file));
        }

        foreach ($form->materials as $material) {
            $product->assignMaterial($material);
        }

        $product->setMeta(new Meta());
        $this->products->save($product);
        return $product;
    }

    public function edit($product_id, AdProductForm $form): void
    {
        $product = $this->products->getAd($product_id);
        $product->edit(
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
            $form->discount
        );

        $product->clearMaterial();
        $this->products->save($product);
        foreach ($form->photo->files as $file){
            $product->addPhoto(AdPhoto::create($file));
        }

        foreach ($form->materials as $material) {
            $product->assignMaterial($material);
        }

        $this->products->save($product);
    }

    public function remove($id): void
    {
        $product = $this->products->getAd($id);
        $this->products->remove($product);
    }

    public function active($id)
    {
        $product = $this->products->getAd($id);
        //TODO Проверки:
        // $free_place = Кол-во оплаченных на текущий месяц + $shop->count_free_product_view
        // Кол-во активированных < или > $free_place
        // Если нехватает, то проверка баланса
        // Если баланс > 0, то:
        //  добавляем новую запись в таблиц потрачено (shop_id, year, mounth, count = 1, date = time())
        //  пересчитываем баланс
        // Иначе исключение Нет Денег!!!!!

        throw new \DomainException('Нельзя активировать');
        $product->active();
        $this->products->save($product);
    }

    public function draft($id)
    {
        $product = $this->products->getAd($id);
        $product->draft();
        $this->products->save($product);
    }

    public function setCost(CostModalForm $form)
    {
        $product = $this->products->getAd($form->id);
        $product->cost = $form->cost;
        $product->discount = $form->discount;
        $this->products->save($product);
    }
}