<?php
/* @var $events array */
?>
<?php foreach ($events as $event): ?>
    <a href="<?= $event['link'] ?>">
        <div class="row">

            <?= date('H:i:s', $event['date']) ?>
            <?= $event['event'] ?>
        </div>
    </a>
<?php endforeach; ?>


