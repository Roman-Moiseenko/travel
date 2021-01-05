<?php


namespace frontend\controllers;


use booking\services\yandex\YandexMarket;
use yii\caching\TagDependency;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class MarketController extends Controller
{
    private $generator;

    public function __construct($id, $module, YandexMarket $generator, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->generator = $generator;
    }

    public function actionTurbo(): Response
    {
        $xml =  \Yii::$app->cache->getOrSet('turbo', function () {
            return $this->generator->generateTurbo();
        }, 4 * 3600, new TagDependency(['tags' => ['categories', 'products']]));

        return \Yii::$app->response->sendContentAsFile($xml, 'turbo.xml', [
            'mimeType' => 'application/xml',
            'inline' => true,
        ]);
    }
}