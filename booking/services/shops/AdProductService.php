<?php


namespace booking\services\shops;


use booking\entities\admin\Debiting;
use booking\entities\Meta;
use booking\entities\shops\AdShop;
use booking\entities\shops\products\AdPhoto;
use booking\entities\shops\products\AdProduct;
use booking\entities\shops\products\Size;
use booking\forms\shops\AdProductForm;
use booking\forms\shops\CostModalForm;
use booking\repositories\office\PriceListRepository;
use booking\repositories\shops\ProductRepository;
use booking\services\admin\UserManageService;

class AdProductService
{

    /**
     * @var ProductRepository
     */
    private $products;
    /**
     * @var AdShopService
     */
    private $serviceAd;
    /**
     * @var UserManageService
     */
    private $serviceUser;
    /**
     * @var PriceListRepository
     */
    private $priceList;

    public function __construct(
        ProductRepository $products,
        AdShopService $serviceAd,
        UserManageService $serviceUser,
        PriceListRepository $priceList
)
    {
        $this->products = $products;
        $this->serviceAd = $serviceAd;
        $this->serviceUser = $serviceUser;
        $this->priceList = $priceList;
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
            $this->priceList->getPrice(AdShop::class),
            Debiting::DEBITING_SHOP,
            '/shop-ad/product?id=' . $product->id
        );
        $this->serviceAd->setActivePlace($shop->id, $shop->countActivePlace() + 1);
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