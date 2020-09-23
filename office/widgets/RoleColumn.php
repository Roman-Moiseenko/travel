<?php


namespace office\widgets;


use booking\entities\Rbac;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\rbac\Item;

class RoleColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $roles = \Yii::$app->authManager->getRolesByUser($model->id);
        return $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(function (Item $role) {
            return $this->getRoleLabel($role);
        }, $roles));
    }

    private function getRoleLabel(Item $role): string
    {
        switch ($role->name) {
            case Rbac::ROLE_SUPPORT: $class = 'default'; break;
            case Rbac::ROLE_MANAGER: $class = 'warning'; break;
            case Rbac::ROLE_ADMIN: $class = 'danger'; break;
            default: $class = 'primary';

        }
        return Html::tag('span', Html::encode($role->description), ['class' => 'badge badge-' . $class]);
    }
}