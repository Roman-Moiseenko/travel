<?php


namespace console\controllers;


use booking\entities\admin\Debiting;
use booking\entities\PhotoResize;
use booking\entities\shops\Shop;
use booking\repositories\office\PriceListRepository;
use booking\services\PhotoResizeService;
use yii\console\Controller;

class ServicesController extends Controller
{

    /**
     * @var PhotoResizeService
     */
    private $servicePhotoResize;
    /**
     * @var PriceListRepository
     */
    private $priceList;

    public function __construct(
        $id,
        $module,
        PhotoResizeService $servicePhotoResize,
        PriceListRepository $priceList,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->servicePhotoResize = $servicePhotoResize;
        $this->priceList = $priceList;
    }

    public function actionResizePhoto()
    {
        $host = \Yii::$app->params['staticPath'];
        $categories = \Yii::$app->params['resize_categories'];
        foreach ($categories as $type) {
            $max_width = isset($type['width']) ? $type['width'] : null;
            $max_height = isset($type['height']) ? $type['height'] : null;
            $quality = $type['quality'];
            foreach ($type['items'] as $category) {
                $this->find($host . $category, $quality, $max_width, $max_height);
            }
        }
    }

    public function actionCacheClear()
    {
        $photoResizes = PhotoResize::find()->andWhere(['like', 'file', 'cache'])->all();
        foreach ($photoResizes as $record) {
            $record->delete();
        }
    }

    public function actionPay()
    {
        $shops = Shop::find()->all();
        foreach ($shops as $shop) {
            if ($shop->isAd()) { //Витрина
                echo $shop->id . PHP_EOL;
                $user = $shop->user;
                $how_count = $shop->activePlace() - $shop->free_products; //За сколько товаров надо заплатить (от активных отнимаем бесплатные)
                echo $how_count . PHP_EOL;
                if ($how_count > 0) {
                    $how_pay = $how_count * $this->priceList->getPrice(Shop::class); // Сколько платить
                    if ($user->Balance() >= $how_pay) {         //баланс больше стоимость
                        $debiting = Debiting::create(
                            $how_pay,
                            Debiting::DEBITING_SHOP,
                            'Ежемесячная оплата за ' . $how_count . ' товара',
                            ''
                        );
                        $debiting->setUser($shop->user_id);
                        $debiting->save();
                        $shop->setActivePlace($how_count);
                        $shop->save();
                    } else { //Баланса не хватает, отправляем все товары в черновик
                        //TODO отправить письмо юзеру
                        foreach ($shop->activeProducts as $product) {
                            $product->draft();
                            $product->save();
                        }
                    }
                } else {    //Платить не надо, тогда сбрасываем кол-во оплаченных ранее
                    $shop->setActivePlace(0);
                    $shop->save();
                }

            } else {
                if ($shop->active_products != 0) {
                    $shop->active_products = 0;
                    $shop->save();
                }
            }
        }
    }

    private function find($category, $quality, $max_width, $max_height): bool
    {
        if (!is_dir($category)) return false;
        $list = scandir($category);
        foreach ($list as $item) {
            if ($item == '.' || $item == '..') continue;
            if (is_dir($category . $item . '/')) {
                $this->find($category . $item . '/', $quality, $max_width, $max_height);
            } else {
                $this->servicePhotoResize->resize($category . $item , $quality, $max_width, $max_height);
            }
        }
        return true;
    }


}