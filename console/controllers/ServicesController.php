<?php


namespace console\controllers;


use booking\services\PhotoResizeService;
use yii\console\Controller;

class ServicesController extends Controller
{

    /**
     * @var PhotoResizeService
     */
    private $servicePhotoResize;

    public function __construct($id, $module, PhotoResizeService $servicePhotoResize, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->servicePhotoResize = $servicePhotoResize;
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