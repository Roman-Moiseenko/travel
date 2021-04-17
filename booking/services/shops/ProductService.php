<?php


namespace booking\services\shops;


use booking\entities\admin\Debiting;
use booking\entities\Meta;
use booking\entities\shops\products\BaseProduct;
use booking\entities\shops\products\Photo;
use booking\entities\shops\products\Product;
use booking\entities\shops\products\Size;
use booking\entities\shops\Shop;
use booking\forms\shops\CostModalForm;
use booking\forms\shops\ProductForm;
use booking\repositories\office\PriceListRepository;
use booking\repositories\shops\ProductRepository;
use booking\services\admin\UserManageService;

class ProductService
{

    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var UserManageService
     */
    private $serviceUser;
    /**
     * @var PriceListRepository
     */
    private $priceList;
    /**
     * @var ShopService
     */
    private $service;

    public function __construct(
        ProductRepository $products,
        ShopService $service,
        UserManageService $serviceUser,
        PriceListRepository $priceList
    )
    {
        $this->products = $products;
        $this->serviceUser = $serviceUser;
        $this->priceList = $priceList;
        $this->service = $service;
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
            $form->request_available,
            $form->quantity
        );
        $product->shop_id = $shop_id;
//        $this->products->save($product);
//        $product->clearMaterial();
        foreach ($form->photo->files as $file) {
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
        $product = $this->products->get($product_id);
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
            $form->discount,
            $form->deadline,
            $form->request_available,
            $form->quantity
        );

        $product->clearMaterial();
        $this->products->save($product);
        foreach ($form->photo->files as $file) {
            $product->addPhoto(Photo::create($file));
        }

        foreach ($form->materials as $material) {
            $product->assignMaterial($material);
        }

        $this->products->save($product);
    }

    public function remove($id): void
    {
        $product = $this->products->get($id);
        //TODO Сделать проверку на возможность удаления
        $this->products->remove($product);
    }

    public function active($id)
    {
        $product = $this->products->get($id);
        if (!$product->shop->isActive()) {
            throw new \DomainException('Сначала активируйте магазин');
        }
        if ($product->isAd()) {
            //TODO оплата и т.п.
            $shop = $product->shop;
            //Кол-во оплаченных на текущий месяц
            $free_place = $shop->free_products + $shop->countActivePlace();
            $active = $shop->activePlace();
            // Кол-во активированных < или > $free_place
            if ($free_place > $active) {
                $product->active();
                $this->products->save($product);
                return;
            }
            $balance = $shop->user->Balance(); //пересчитываем баланс
            if ($balance <= 0) {  // исключение Нет Денег!!!!!
                throw new \DomainException('Недостаточно денег на балансе');
            }
            //  добавляем новую запись в таблиц потрачено
            $this->serviceUser->addDebiting(
                $shop->user_id,
                $this->priceList->getPrice(Shop::class),
                Debiting::DEBITING_SHOP,
                $product->name,
                '/shop/product?id=' . $product->id
            );
            $this->service->setActivePlace($shop->id, $shop->countActivePlace() + 1);
            $product->active();
            $this->products->save($product);
        } else {
            $product->active();
            $this->products->save($product);
        }
    }

    public function draft($id)
    {
        $product = $this->products->get($id);
        $product->draft();
        $this->products->save($product);
    }

    public function setCost(CostModalForm $form)
    {
        $product = $this->products->get($form->id);
        $product->cost = $form->cost;
        $product->quantity = $form->quantity;
        $product->discount = $form->discount;
        $this->products->save($product);
    }
}