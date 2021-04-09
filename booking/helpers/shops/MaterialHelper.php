<?php


namespace booking\helpers\shops;


use booking\entities\shops\products\Material;
use yii\helpers\ArrayHelper;

class MaterialHelper
{
    
    public static function list(): array 
    {
        return ArrayHelper::map(Material::find()->asArray()->all(), 'id', 'name');
    }
}