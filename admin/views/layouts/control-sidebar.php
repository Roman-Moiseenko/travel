<?php

use admin\widgest\SideBarWidget;

?>
<aside class="control-sidebar control-sidebar-dark overflow-auto">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Последние события</h5>
        <?= SideBarWidget::widget();?>
    </div>
</aside>