<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \booking\forms\booking\stays\search\SearchStayForm */

/* @var $dataProvider DataProviderInterface */

use booking\entities\Lang;

use booking\forms\booking\stays\search\SearchStayForm;
use booking\helpers\Emoji;
use booking\helpers\SysHelper;
use frontend\widgets\gallery\GalleryStayWidget;
use yii\data\DataProviderInterface;
use yii\helpers\Html;

$this->title = 'Базы отдыха, гостиницы, отели, дома и виллы, квартиры и апартаменты в Калининграде и области';
$mobile = SysHelper::isMobile();
$this->params['emoji'] = Emoji::STAY;
$mobile = SysHelper::isMobile();
?>

<h1 class="pt-4 pb-2">Проживание в Калиниграде</h1>
<p>Раздел находится в разработке, до запуска примерно 1-2 месяца</p>
    <?= GalleryStayWidget::widget([
        'categories' => $categories,
        'mobile' => $mobile,
    ]) ?>
