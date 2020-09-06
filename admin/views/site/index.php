<?php
$this->title = 'Добро пожаловать!';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <?= \hail812\adminlte3\widgets\Callout::widget([
                'type' => 'info',
                'head' => 'Спасибо, что Вы с нами!',
                'body' => 'Потом напишу крутой текст бла-бла-бла'
            ]) ?>
        </div>
    </div>
</div>