<?php

use booking\entities\art\event\Category;
use booking\entities\art\event\Event;
use booking\helpers\Emoji;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $categories Category[] */
/* @var $events Event[] */
/* @var $currentCategory Category|null */



if ($currentCategory) {
    $this->params['breadcrumbs'][] = ['label' => 'События', 'url' => Url::to(['/art/events'])];
    $this->params['breadcrumbs'][] = $currentCategory->name;
    $this->registerMetaTag(['name' => 'description', 'content' => $currentCategory->meta->description]);
    $this->registerMetaTag(['name' => 'og:description', 'content' => $currentCategory->meta->description]);

    $this->title = $currentCategory->meta->title ? $currentCategory->meta->title : $currentCategory->name;
} else {
    $this->params['breadcrumbs'][] = 'События';
    $description = 'Фестивали, Ярмарки, Мероприятия в Калининграде. Календарь проведения праздников в Калининградской области';
    $this->registerMetaTag(['name' => 'description', 'content' => $description]);
    $this->registerMetaTag(['name' => 'og:description', 'content' => $description]);
    $this->title = 'Фестивали, Ярмарки, Мероприятия в Калининграде';
}
$this->params['emoji'] = Emoji::ART;
?>

<h1 class="pt-4 pb-2">Фестивали, Ярмарки, Мероприятия <?= $currentCategory ? ' - ' . $currentCategory->name : ''?></h1>

<?php foreach ($categories as $category): ?>
    <?php if ($currentCategory && $category->isFor($currentCategory->id)): ?>
    <?php else:?>
    <a class="tag-widget" href="<?= Url::to(['/art/event/category', 'slug' => $category->slug])?>"><span><?= $category->icon . ' ' . $category->name ?></span></a>
    <?php endif ?>
<?php endforeach; ?>


<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3"> <!-- row-cols-lg-4-->
    <?php foreach ($events as $event): ?>
        <?= $this->render('_event', [
            'event' => $event
        ]) ?>
    <?php endforeach; ?>
</div>