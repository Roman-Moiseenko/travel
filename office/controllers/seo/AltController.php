<?php


namespace office\controllers\seo;

use booking\entities\booking\BasePhoto;
use booking\entities\Rbac;
use booking\forms\office\AltForm;
use booking\helpers\scr;
use booking\repositories\office\PhotoRepository;
use booking\services\PhotoResizeService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AltController extends Controller
{

    /**
     * @var PhotoRepository
     */
    private $photos;
    /**
     * @var PhotoResizeService
     */
    private $servicePhotoResize;

    public function __construct($id, $module, PhotoRepository $photos, PhotoResizeService $servicePhotoResize, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->photos = $photos;
        $this->servicePhotoResize = $servicePhotoResize;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $form = new AltForm();
        //Получаем список всех объектов где поле фото с пустым alt
        /** @var BasePhoto[] $photos */
        $photos = $this->photos->getAltEmpty();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                foreach ($photos as $i => $photo) {
                    if (get_class($photo) == $form->class_name && $photo->id == $form->id) {
                        $photo->setAlt($form->alt);
                        $photo->save();
                        unset($photos[$i]);
                        break;
                    }
                }
            } catch (\Throwable $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'objects' => $photos,
            'model' => $form,
        ]);
    }

    public function actionUpdate()
    {
        $form = new AltForm();
        //Получаем список всех объектов где поле фото не пустым alt
        /** @var BasePhoto[] $photos */
        $photos = $this->photos->getAltNotEmpty();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                foreach ($photos as $i => &$photo) {
                    if (get_class($photo) == $form->class_name && $photo->id == $form->id) {
                        $photo->setAlt($form->alt);
                        $photo->save();
                        break;
                    }
                }
            } catch (\Throwable $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'objects' => $photos,
            'model' => $form,
        ]);
    }
/*
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
    }*/
}