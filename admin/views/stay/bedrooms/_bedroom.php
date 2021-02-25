<?php

use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\bedroom\TypeOfBed;
use booking\entities\booking\stays\Stay;
use booking\helpers\SysHelper;

/* @var $stay Stay */
/* @var $bedrooms AssignRoom[] */

$mobile = SysHelper::isMobile();
?>
<input type="hidden" id="count-bedrooms" value="<?= count($bedrooms) ?>">
<?php if (count($bedrooms) == 0): ?>
    <label>У вас нет ни одной спальни, добавьте спальню и укажите количество кроватей:</label>
<?php endif; ?>
<?php foreach ($bedrooms as $i => $bedroom): ?>
    <div class="row">
        <div class="col-sm-11 col-md-10 col-lg-8 col-xl-5">
            <div class="card">
                <div class="card-header px-4 py-4" style="color: #1e6186;">
                    <div class="d-flex">
                        <div>
                            <i class="fas fa-bed"></i>&#160;&#160;
                            Спальня <?= $i + 1 ?>
                        </div>
                        <div class="ml-auto link-admin">
                            <span id="counts-<?= $i ?>"><?= $bedroom->getCounts() ?></span>&#160;&#160;
                            <i class="fas fa-user-circle"></i>
                        </div>
                    </div>
                    <a href="#collapse-<?= $i ?>" class="stretched-link" data-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="collapseExample"></a>
                    <input type="hidden" id="bedroom-<?= $i ?>">
                </div>
                <div class="collapse" id="collapse-<?= $i ?>">
                    <div class="card-body">
                        <?php foreach (TypeOfBed::find()->all() as $j => $typeOfBed): ?>
                            <div class="<?= $mobile ? 'row' : 'd-flex' ?>">
                                <div>
                                    <?= $typeOfBed->name ?>
                                    <input type="hidden" name="BedroomsForm[<?= $i ?>][bed_type][<?= $j ?>]"
                                           value="<?= $typeOfBed->id ?>">
                                </div>
                                <div class="ml-auto">
                                    <input class="form-control form-control-sm input-beds" type="number" min="0"
                                           max="10"
                                           name="BedroomsForm[<?= $i ?>][bed_count][<?= $j ?>]"
                                           id="bed-<?= $i ?>-<?= $j ?>"
                                           data-room="<?= $i ?>"
                                           data-bed-id="<?= $typeOfBed->id ?>"
                                           data-count="<?= $typeOfBed->count ?>"
                                           value="<?= $bedroom->getCount($typeOfBed->id) ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1">
            <span class="btn btn-sm btn-warning del-bedrooms" data-room-id="<?= $i ?>">x</span>
        </div>
    </div>
<?php endforeach; ?>
