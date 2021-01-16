<?php


namespace office\widgets;


use booking\entities\booking\cars\Car;
use booking\entities\booking\funs\Fun;
use booking\entities\booking\tours\Tour;
use booking\helpers\StatusHelper;
use booking\repositories\booking\funs\FunRepository;
use yii\base\Widget;
use yii\helpers\Url;

class ActiveTopWidget extends Widget
{

    public function run()
    {
        //TODO Заглушка Stays

        //TODO поставить путое фото-заглушку
        $count = 0;
        $objects = [];
        $tours = Tour::find()->verify()->all();
        $cars = Car::find()->verify()->all();
        $funs = Fun::find()->verify()->all();
        foreach ($tours as $tour) {
            $objects[] = ['name' => $tour->name,
                'photo' => $tour->mainPhoto ? $tour->mainPhoto->getThumbFileUrl('file', 'top_widget_list') : '',
                'link' => Url::to(['tours/view', 'id' => $tour->id]),
                'created_at' => date('d-m-Y', $tour->created_at),
                ];
        }
        foreach ($cars as $car) {
            $objects[] = ['name' => $car->name,
                'photo' => $car->mainPhoto ? $car->mainPhoto->getThumbFileUrl('file', 'top_widget_list') : '',
                'link' => Url::to(['cars/view', 'id' => $car->id]),
                'created_at' => date('d-m-Y', $car->created_at),
            ];
        }

        foreach ($funs as $fun) {
            $objects[] = ['name' => $fun->name,
                'photo' => $fun->mainPhoto ? $fun->mainPhoto->getThumbFileUrl('file', 'top_widget_list') : '',
                'link' => Url::to(['funs/view', 'id' => $fun->id]),
                'created_at' => date('d-m-Y', $fun->created_at),
            ];
        }

        $count = count($objects);
        return $this->render('active_top', [
            'objects' => $objects,
            'count' => $count,
        ]);
    }
}