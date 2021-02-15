<?php

use yii\db\Migration;

/**
 * Class m210215_161618_add_booking_stays_type_fields
 */
class m210215_161618_add_booking_stays_type_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_type}}', 'sort', $this->integer()->defaultValue(0));
        $this->addColumn('{{%booking_stays_type}}', 'slug', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays_type}}', 'sort');
        $this->dropColumn('{{%booking_stays_type}}', 'slug');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210215_161618_add_booking_stays_type_fields cannot be reverted.\n";

        return false;
    }
    */
}
