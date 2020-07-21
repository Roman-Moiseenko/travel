<?php


namespace frontend\controllers\cabinet;


use yii\filters\AccessControl;
use yii\web\Controller;

class WishlistController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}