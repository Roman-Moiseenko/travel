<?php

use booking\entities\booking\trips\activity\Activity;
use booking\entities\booking\trips\placement\MealsAssignment;
use booking\entities\booking\trips\placement\room\Room;
use booking\entities\booking\trips\Trip;

/* @var $trip Trip */
/* @var $errors array */


?>

<div class="card card-success" style="max-width: 400px">
    <div class="card-header">Добавить</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Количество мест</label>
                    <input class="form-control" id="quantity" type="number"
                           min="0"
                           value="<?= $trip->params->capacity ?>"
                           width="100px" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Базовая цена</label>
                    <input class="form-control" id="cost_base" type="number" value="<?= $trip->cost_base ?>" min="0"
                           step="50" width="100px" required>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($trip->params->transfer)): ?>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Трансфер</label>
                        <input class="form-control cost-params" id="params_transfer" type="number"
                               data-params="transfer"
                               value="<?= $trip->params->transfer ?>" min="0"
                               step="50" width="100px" required>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-12"><label>Проживание</label></div>

        <?php foreach ($trip->placements as $i => $placement): ?>
            <div class="row">
                <?php foreach ($placement->rooms as $room): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <p><?= '' . ($i + 1) . ') ' . $placement->name . ' ' . $room->name ?></p>
                            <input class="form-control cost-list" id="room-<?= $room->id ?>" type="number"
                                   data-id="<?= $room->id ?>"
                                   data-class="<?= Room::class ?>"
                                   value="<?= $room->cost ?>" min="0"
                                   step="50" width="100px" required>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if ($placement->mealsAssignment): ?>
                    <div class="col-12"><span>Питание</span></div><?php endif; ?>
                <?php foreach ($placement->mealsAssignment as $assignment): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <p><?= '' . ($i + 1) . ') ' . $assignment->meals->mark ?></p>
                            <input class="form-control cost-list" id="meal-<?= $assignment->meal_id ?>" type="number"
                                   data-id="<?= $assignment->meal_id ?>"
                                   data-class="<?= MealsAssignment::class ?>"
                                   value="<?= $assignment->cost ?>" min="0"
                                   step="50" width="100px" required>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <div class="col-12"><label>Мероприятия (только с ценами)</label></div>
        <div class="row">
            <?php foreach ($trip->activities as $activity): ?>
                <?php if (!empty($activity->cost)): ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <p><?= $activity->caption ?></p>
                            <input class="form-control cost-list" id="activity-<?= $activity->id ?>" type="number"
                                   data-id="<?= $activity->id ?>"
                                   data-class="<?= Activity::class ?>"
                                   value="<?= $activity->cost ?>" min="0"
                                   step="50" width="100px" required>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col">
                <a href="#" class="btn btn-success" id="send-new-trip">Добавить</a>
            </div>
        </div>
        <?php if (isset($errors['new_trip'])): ?>
            <div class="row">
                <div class="col">
                    <div class="error-message"><?= $errors['new_trip'] ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>