<?php


namespace booking\sms;


use booking\helpers\scr;
use stdClass;

class sms
{
    public function Init()
    {

    }

    public static function send($phone, $message): bool
    {
        $sms = new SMSRU(\Yii::$app->params['SMS_API']);
        $data = new stdClass();
        $data->to = $phone;
        $data->text = $message;
        $sms = $sms->send_one($data);
        if ($sms->status == 'OK') {
            return true;
        } else {
            \Yii::error('Ошибка отправки СМС. ' . $sms->status_text . ' (' . $sms->status_code . ')');
            return false;
        }
    }


    public static function getBalance()
    {
        $sms = new SMSRU(\Yii::$app->params['SMS_API']);
        $request = $sms->getBalance();
        if ($request->status == "OK") { // Запрос выполнен успешно
            return $request->balance;
        } else {
            \Yii::error('Ошибка отправки СМС. ' . $sms->status_text . ' (' . $sms->status_code . ')');
            return false;
        }
    }
}