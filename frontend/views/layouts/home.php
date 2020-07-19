<?php
/* @var $this \yii\web\View */

/* @var $content string */

?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="row">
    <!-- -->
    <div id="content" class="col-sm-12">
        <!-- ПОИСК -->
        <header id="header-top">
            <div class="container">
                <div class="row">
                    ВИДЖЕТ ПОИСКА
                </div>
            </div>
        </header>
        <!-- РЕКОМЕНДУЕМ -->
        <h3>Рекомендуем для отдыха</h3>
            ВИДЖЕТ
        <!-- ПОСТЫ -->
        <h3>100(0) замечательных мест Кенингсберга</h3>
            ВИДЖЕТ (random)
        <!-- БРЕНДЫ -->
        <div class="hidden-xs">
            ВИДЖЕТ БРЕНДЫ
        </div>
    </div>
</div>

<?php $this->endContent() ?>
