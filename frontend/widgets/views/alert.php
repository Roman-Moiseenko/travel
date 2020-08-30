<?php

/* @var $class string */
/* @var $message string */
?>


<div class="alert alert-<?= $class ?> alert-dismissible fade show" role="alert">
    <span class="p-1 m-1" style="font-size: 14px"><?= $message ?></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
