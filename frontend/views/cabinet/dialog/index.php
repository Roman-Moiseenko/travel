<?php

use booking\entities\Lang;
use booking\entities\message\Dialog;

/* @var $dialogs Dialog[] */
$this->title = Lang::t('Сообщения');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php foreach ($dialogs as $dialog): ?>



<?php endforeach; ?>
