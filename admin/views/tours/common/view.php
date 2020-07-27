<?php

use booking\entities\booking\tours\Tours;
use booking\forms\booking\tours\ToursCommonForms;
use booking\helpers\ToursTypeHelper;
use kartik\widgets\FileInput;
//use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var  $tours Tours*/


$this->title = 'Тур ' . $tours->name;
$this->params['breadcrumbs'][] = ['label' => 'Туры', 'url' => ['/tours']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">


    <div class="box box-default">
        <div class="box-header with-border"></div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-9">

                </div>
            </div>
            <?= $tours->description ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">Расположение</div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-8">
                            <input id="bookingaddressform-address" value="">

                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-latitude" value="<?= $tours->address->latitude?>">

                        </div>
                        <div class="col-2">
                            <input id="bookingaddressform-longitude" value="<?= $tours->address->longitude?>">
                        </div>
                    </div>

                    <div class="row">
                        <div id="map" style="width: 100%; height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Категории</div>
                <div class="box-body">

                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Редактировать', ['class' => 'btn btn-success']) ?>
    </div>
    

</div>

