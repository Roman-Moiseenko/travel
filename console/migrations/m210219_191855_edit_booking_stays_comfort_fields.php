<?php

use yii\db\Migration;

/**
 * Class m210219_191855_edit_booking_stays_comfort_fields
 */
class m210219_191855_edit_booking_stays_comfort_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%booking_stays_comfort}}', 'image');
        $this->addColumn('{{%booking_stays_comfort}}', 'photo', $this->boolean()->defaultValue(false));
        $this->renameColumn('{{%booking_stays_comfort_assign}}', 'photo', 'photo_id');
        $this->alterColumn('{{%booking_stays_comfort_assign}}', 'photo_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210219_191855_edit_booking_stays_comfort_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210219_191855_edit_booking_stays_comfort_fields cannot be reverted.\n";

        return false;
    }
    */
}
