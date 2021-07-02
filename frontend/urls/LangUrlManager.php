<?php


namespace frontend\urls;


use booking\entities\Lang;
use booking\helpers\scr;
use yii\web\UrlManager;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if(isset($params['lang']) ){
            //Если указан идентефикатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
            $lang = Lang::isset($params['lang']) ? $params['lang'] : Lang::current();
            unset($params['lang']);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::current();
        }
        $url = parent::createUrl($params);
        return $url == '/' ? '/' . $lang : '/' . $lang . $url;
    }
}