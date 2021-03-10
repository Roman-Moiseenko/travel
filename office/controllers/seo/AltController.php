<?php


namespace office\controllers\seo;

use booking\entities\booking\BasePhoto;
use booking\entities\Rbac;
use booking\forms\office\AltForm;
use booking\repositories\booking\ObjectRepository;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AltController extends Controller
{

    /**
     * @var ObjectRepository
     */
    private $objects;

    public function __construct($id, $module, ObjectRepository $objects, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->objects = $objects;
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
        /** @var BasePhoto[] $objects */
        $objects = $this->objects->getAltEmpty();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                foreach ($objects as $i => $object) {
                    if (get_class($object) == $form->class_name && $object->id == $form->id) {
                        $object->setAlt($form->alt);
                        $object->save();
                        unset($objects[$i]);
                        break;
                    }
                }
            } catch (\Throwable $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'objects' => $objects,
            'model' => $form,
        ]);
    }
}