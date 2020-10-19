<?php


namespace booking\sms;


use booking\helpers\scr;
use stdClass;

class sms
{
    public function Init()
    {

    }

    public static function send($phone, $message)
    {
        $sms = new SMSRU(\Yii::$app->params['SMS_API']);
        $data = new stdClass();
        $data->to = $phone;
        $data->text = $message;
        $sms = $sms->send_one($data);
        if ($sms->status != "OK")
            throw new \DomainException('Ошибка отправки СМС. ' . $sms->status_text . ' (' . $sms->status_code . ')');
    }


    public static function getBalance()
    {
        $sms = new SMSRU(\Yii::$app->params['SMS_API']);
        $request = $sms->getBalance();
        if ($request->status == "OK") { // Запрос выполнен успешно
            return $request->balance;
        } else {
            throw new \DomainException('Ошибка отправки СМС. ' . $request->status_text . ' (' . $request->status_code . ')');
        }
    }
}