<?php


namespace office\controllers\seo;

use booking\entities\booking\BasePhoto;
use booking\entities\Rbac;
use booking\forms\office\AltForm;
use booking\helpers\scr;
use booking\repositories\office\PhotoRepository;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AltController extends Controller
{

    /**
     * @var PhotoRepository
     */
    private $photos;

    public function __construct($id, $module, PhotoRepository $photos, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->photos = $photos;
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
}