<?php
$this->title = 'Администрирование Koenigs';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <?= \hail812\adminlte3\widgets\Callout::widget([
                'type' => 'info',
                'head' => 'Заголовок',
                'body' => 'Инфа текущего дня, добавить ссылки для провайдера и клиента'
            ]) ?>
        </div>
    </div>
</div>