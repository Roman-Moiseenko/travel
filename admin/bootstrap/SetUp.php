<?php


namespace backend\bootstrap;


use booking\entities\shops\cart\Cart;
use booking\entities\shops\cart\cost\calculator\SimpleCost;
use booking\entities\shops\cart\storage\HybridStorage;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\base\Application;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(CKEditor::class, [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
        ]);
    }
}