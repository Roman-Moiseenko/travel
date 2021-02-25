<?php

use booking\entities\booking\stays\nearby\Nearby;

/* @var $nearby Nearby[] */
/* @var $category_id integer */

?>
<input type="hidden" id="count-nearby-<?= $category_id ?>" value="<?= count($nearby) ?>">
<?php foreach ($nearby as $i => $item): ?>
    <div class="row" id="item-nearby-<?= $i ?>">
        <div class="col-sm-6">
            <label>Название:</label>
            <input class="form-control" id="nearby-name-<?= $category_id ?>-<?= $i ?>" name="NearbyForm[<?= $category_id * 10 + $i ?>][name]"
                   value="<?= $item->name ?>">
            <input type="hidden" name="NearbyForm[<?= $category_id * 10 + $i ?>][category_id]"
                   value="<?= $category_id ?>">
        </div>
        <div class="col-sm-3">
            <label>Расстояние:</label>
            <div class="d-flex">
                <div>
                    <input class="form-control" id="nearby-distance-<?= $category_id ?>-<?= $i ?>"
                           type="number" min="0"
                           name="NearbyForm[<?= $category_id * 10 + $i ?>][distance]" value="<?= $item->distance ?>"
                           style="width: 100px !important;">
                </div>
                <div class="form-group">
                    <select class="form-control" id="nearby-unit-<?= $category_id ?>-<?= $i ?>" name="NearbyForm[<?= $category_id * 10 + $i ?>][unit]">
                        <option value="м">м</option>
                        <option value="км" <?= $item->unit == 'км' ? 'selected' : ''?>>км</option>
                    </select>
                </div>
                <div class="pl-3 align-items-end">
                    <span class="sub-nearby btn btn-sm btn-warning align-bottom" data-category="<?= $category_id ?>" data-i="<?= $i ?>">x</span>
                </div>
            </div>
        </div>

    </div>
<?php endforeach; ?>
