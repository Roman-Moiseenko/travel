<?php

use booking\entities\booking\stays\rules\Rules;
use yii\db\Migration;

/**
 * Class m210303_210010_add_booking_stays_rules_params_fields
 */
class m210303_210010_add_booking_stays_rules_params_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_rules}}', 'beds_child_on', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'beds_child_agelimit', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'beds_child_cost', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'beds_child_by_adult', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'beds_child_count', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'beds_adult_on', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'beds_adult_cost', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'beds_adult_count', $this->integer()->defaultValue(0));

        $this->addColumn('{{%booking_stays_rules}}', 'parking_status', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_private', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_inside', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_reserve', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_cost', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_cost_type', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_security', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_covered', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_street', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'parking_invalid', $this->boolean()->defaultValue(false));


        $this->addColumn('{{%booking_stays_rules}}', 'checkin_checkin_from', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'checkin_checkin_to', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'checkin_checkout_from', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'checkin_checkout_to', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'checkin_message', $this->boolean()->defaultValue(false));

        $this->addColumn('{{%booking_stays_rules}}', 'limit_smoking', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'limit_animals', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'limit_children', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%booking_stays_rules}}', 'limit_children_allow', $this->integer()->defaultValue(0));

        $rules = Rules::find()->all();
        foreach ($rules as $rule) {
            $this->update('{{%booking_stays_rules}}', [
                'beds_child_on' => $rule->beds->child_on,
                'beds_child_agelimit' => $rule->beds->child_agelimit,
                'beds_child_cost' => $rule->beds->child_cost,
                'beds_child_by_adult' => $rule->beds->child_by_adult,
                'beds_child_count' => $rule->beds->child_count,
                'beds_adult_on' => $rule->beds->adult_on,
                'beds_adult_cost' => $rule->beds->adult_cost,
                'beds_adult_count' => $rule->beds->adult_count,

                'parking_status' => $rule->parking->status,
                'parking_private' => $rule->parking->private,
                'parking_inside' => $rule->parking->inside,
                'parking_reserve' => $rule->parking->reserve,
                'parking_cost' => $rule->parking->cost,
                'parking_cost_type' => $rule->parking->cost_type,
                'parking_security' => $rule->parking->security,
                'parking_covered' => $rule->parking->covered,
                'parking_street' => $rule->parking->street,
                'parking_invalid' => $rule->parking->invalid,

                'checkin_checkin_from' => $rule->checkin->checkin_from,
                'checkin_checkin_to' => $rule->checkin->checkin_to,
                'checkin_checkout_from' => $rule->checkin->checkout_from,
                'checkin_checkout_to' => $rule->checkin->checkout_to,
                'checkin_message' => $rule->checkin->message,

                'limit_smoking' => $rule->limit->smoking,
                'limit_animals' => $rule->limit->animals,
                'limit_children' => $rule->limit->children,
                'limit_children_allow' => $rule->limit->children_allow,
            ], 'id = ' . $rule->id);
        }

        $this->dropColumn('{{%booking_stays_rules}}', 'beds_json');
        $this->dropColumn('{{%booking_stays_rules}}', 'parking_json');
        $this->dropColumn('{{%booking_stays_rules}}', 'checkin_json');
        $this->dropColumn('{{%booking_stays_rules}}', 'limit_json');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210303_210010_add_booking_stays_rules_params_fields cannot be reverted.\n";

        return false;
    }

}
