<?php


namespace frontend\controllers\moving;


use booking\entities\moving\CloseLink;
use booking\services\system\LoginService;
use yii\helpers\Url;
use yii\web\Controller;

class CloseController extends Controller
{
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct($id, $module, LoginService $loginService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->loginService = $loginService;
    }

    public function actionGetLink()
    {
        if (\Yii::$app->request->isAjax) {
            if ($this->loginService->isGuest()) {
                return '<a href="' . Url::to(['/login']) . '">Войти на сайт</a>';
            }
            $link = \Yii::$app->request->bodyParams['link'];
            //получам ссылку с базы
            $url = CloseLink::find()->andWhere(['link' => $link])->one();
            if ($url) {
                return '<a href="' . $url->url . '">' . $url->anchor . '</a>';
            }
            return '';
        } else {
            return $this->goHome();
        }
    }
}