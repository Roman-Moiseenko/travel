<?php


namespace frontend\widgets;


use yii\base\Widget;

class AlertWidget extends Widget
{

    public $link;

    private function listClass(): array
    {
        return [
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'light',
            'dark',
            'error'
        ];
    }
    public function run()
    {
        $list = $this->listClass();
        foreach ($list as $class) {
            if (\Yii::$app->session->hasFlash($class)) {
                $message = \Yii::$app->session->getFlash($class);
                if ($class == 'error') $class = 'danger';
                return $this->render('alert', [
                    'class' => $class,
                    'message' => $message,
                    'link' => $this->link,
                ]);
            }

        }

    }
}