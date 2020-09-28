<?php


namespace office\widgets;


use booking\entities\booking\tours\Tour;
use booking\helpers\StatusHelper;
use yii\base\Widget;
use yii\helpers\Url;

class ActiveTopWidget extends Widget
{

    public function run()
    {
        $count = 0;
        $objects = [];
        $tours = Tour::find()->verify()->all();
        foreach ($tours as $tour) {
            $objects[] = ['name' => $tour->name,
                'photo' => $tour->mainPhoto->getThumbFileUrl('file', 'top_widget_list'),
                'link' => Url::to(['tours/view', 'id' => $tour->id]),
                'created_at' => date('d-m-Y', $tour->created_at),
                ];
        }
        $count = count($objects);
        return $this->render('active_top', [
            'objects' => $objects,
            'count' => $count,
        ]);
    }
}