<?php

use yii\db\Migration;

/**
 * Class m210302_080745_add_booking_stays_comfort_room_featured_field
 */
class m210302_080745_add_booking_stays_comfort_room_featured_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%booking_stays_comfort_room}}', 'featured', $this->boolean()->defaultValue(false));
        $this->update('{{%booking_stays_comfort_room}}', ['featured'=> false]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%booking_stays_comfort_room}}', 'featured');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210302_080745_add_booking_stays_comfort_room_featured_field cannot be reverted.\n";

        return false;
    }
    */
}
