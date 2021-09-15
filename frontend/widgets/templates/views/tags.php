<?php



/* @var $this \yii\web\View */
/* @var $tags array */

?>
<h2 class="pt-5 pb-3">Какие экскурсии в Калининграде вас интересуют?</h2>

<?php foreach ($tags as $tag): ?>
    <a class="tag-widget" href="<?= $tag['link'] ?>"><span><?= $tag['caption'] ?></span></a>
<?php endforeach; ?>
