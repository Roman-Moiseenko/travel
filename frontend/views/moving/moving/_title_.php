<?php
$mobile = SysHelper::isMobile();

?>

<?php use booking\entities\Lang;
use booking\helpers\SysHelper;

if ($mobile): ?>
    <h1 class="landing-moving-h1 pb-2" style="text-align: center !important;"><span
            style="font-size: 36px; text-align: center">Калининградская область</span><br>
        <span class="landing-h2">
                <span class="line-t"></span><?= Lang::t('Переезд на ПМЖ') ?><span
                class="line-b"></span>
            </span>
    </h1>
    <div class="card"
         style="background-color: rgba(255,255,255,0.8) !important;; border-radius: 20px">
        <div class="card-body m-4 p-2"
             style="text-align: justify; color: #000; text-shadow: 0 0 0">
            <h2 style="text-align: center !important;">Как переехать в Калининград</h2>
            <?= $this->render('_caption_text') ?>
        </div>
    </div>
<?php else: ?>
    <div class="item-responsive item-moving">
        <div class="content-item">
            <div class="item-class">
                <div class="item-responsive item-4-3by1">
                    <div class="content-item">
                        <img src="<?= $image ?>" loading="lazy" alt="Переезд на ПМЖ в Калининград" width="100%">
                    </div>
                </div>
                <div class="carousel-caption">
                    <h1 class="landing-moving-h1 py-2">Калининградская область<br>
                        <span class="landing-h2">
                <span class="line-t"></span><?= Lang::t('Переезд на ПМЖ') ?><span
                                class="line-b"></span>
            </span>
                    </h1>
                    <div class="container">
                        <div class="card"
                             style="background-color: rgba(255,255,255,0.8) !important;; border-radius: 20px">
                            <div class="card-body m-4 p-2"
                                 style="text-align: justify; color: #000; text-shadow: 0 0 0">
                                <h2 style="text-align: center !important;">Как переехать в Калининград</h2>
                                <?= $this->render('_caption_text') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
