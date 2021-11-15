<?php
/* @var $this yii\web\View */
/* @var $categories Category[] */

use booking\entities\booking\tours\Tour;
use booking\entities\Lang;
use booking\entities\touristic\fun\Category;
use booking\helpers\Emoji;
use booking\helpers\SysHelper;
use frontend\widgets\gallery\GalleryFunWidget;
use frontend\widgets\templates\TagsWidget;



$_count = count($categories);
$mobile = SysHelper::isMobile();
$this->title = Lang::t('Развлечения и мероприятия в Калининграде - активный культурный экстремальный отдых');
$this->params['emoji'] = Emoji::FUN;

?>
<h1 class="pt-4 pb-2">Отдых и Развлечения в Калининграде</h1>


<?= GalleryFunWidget::widget([
    'categories' => $categories,
    'mobile' => $mobile,
]) ?>

<!--Облако тегов-->
<?= TagsWidget::widget([
    'object' => Tour::class
]) ?>

