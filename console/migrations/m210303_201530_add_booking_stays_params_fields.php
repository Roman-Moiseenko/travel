<?php

use yii\db\Migration;

/**
 * Class m210303_201530_add_booking_stays_params_fields
 */
class m210303_201530_add_booking_stays_params_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays}}', 'params_square', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays}}', 'params_count_bath', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays}}', 'params_count_kitchen', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays}}', 'params_count_floor', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays}}', 'params_guest', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays}}', 'params_deposit', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays}}', 'params_access', $this->integer()->defaultValue(0));
        $this->dropColumn('{{%booking_stays}}', 'params_json');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays}}', 'params_square');
        $this->dropColumn('{{%booking_stays}}', 'params_count_bath');
        $this->dropColumn('{{%booking_stays}}', 'params_count_kitchen');
        $this->dropColumn('{{%booking_stays}}', 'params_count_floor');
        $this->dropColumn('{{%booking_stays}}', 'params_guest');
        $this->dropColumn('{{%booking_stays}}', 'params_deposit');
        $this->dropColumn('{{%booking_stays}}', 'params_access');
        $this->addColumn('{{%booking_stays}}', 'params_json', 'JSON NOT NULL');
    }

}
