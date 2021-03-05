<?php

use yii\db\Migration;

/**
 * Class m210305_105147_add_booking_stays_rules_wifi_fields
 */
class m210305_105147_add_booking_stays_rules_wifi_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_rules}}', 'wifi_status', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'wifi_area', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'wifi_cost', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_rules}}', 'wifi_cost_type', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays_rules}}', 'wifi_status');
        $this->dropColumn('{{%booking_stays_rules}}', 'wifi_area');
        $this->dropColumn('{{%booking_stays_rules}}', 'wifi_cost');
        $this->dropColumn('{{%booking_stays_rules}}', 'wifi_cost_type');
    }

}
