<?php


namespace frontend\controllers\cabinet;


use booking\entities\booking\tours\BookingTour;
use booking\entities\Lang;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TourController extends Controller
{
    public $layout = 'cabinet';
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

    public function actionView($id)
    {
        $booking = $this->findModel($id);
        return $this->render('view', [
            'booking' => $booking,
        ]);
    }

    public function actionUpdate($id)
    {
        $booking = $this->findModel($id);
    }

    public function actionDelete($id)
    {
        $booking = $this->findModel($id);
        $this->bookings->remove($booking->id);
    }

    private function findModel($id)
    {
        if (($model = BookingTour::findOne($id)) !== null) {
            if ($model->user_id !== \Yii::$app->user->id) {
                throw new \DomainException(Lang::t('У вас нет доступа к данному бронированию'));
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}