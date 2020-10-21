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
            //echo 1;
            $lang = Lang::isset($params['lang']) ? $params['lang'] : Lang::current();
            //scr::v([$params['lang'], $lang]);
            //scr::v([$params['lang'], $lang]);
            unset($params['lang']);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::current();
            //scr::v($lang);
        }
        $url = parent::createUrl($params);
       // scr::v([$url, $lang]);
        return $url == '/' ? '/' . $lang : '/' . $lang . $url;
    }
}