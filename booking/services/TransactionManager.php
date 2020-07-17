<?php


namespace booking\services;


class TransactionManager
{
    public function wrap(callable $function):void
    {
        try {
            \Yii::$app->db->transaction($function);
        } catch (\Throwable $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

}